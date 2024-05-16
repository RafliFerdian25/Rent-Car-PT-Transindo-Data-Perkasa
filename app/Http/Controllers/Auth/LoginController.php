<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Mentor;
use App\Models\Student;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login()
    {
        $user = Auth::user();

        if ($user) {
            return redirect()->intended();
        }

        $data =  [
            'title' => 'Login | Rent Car',
        ];

        return view('auth.login', $data);
    }

    public function authenticate(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                // Form salah diisi
                return $request->ajax()
                    ? ResponseFormatter::error(
                        [
                            'error' => $validator->errors()->first(),
                        ],
                        'Harap isi form dengan benar',
                        400,
                    )
                    : back()->with(['error' => $validator->errors()->first()]);
            }

            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $redirect = redirect('/');
                $request->session()->regenerate();
                return ResponseFormatter::success(['redirect' => $redirect->getTargetUrl()], 'Authenticated');
            } else {
                $msg = 'Mohon maaf email/password Anda tidak sesuai';
                return $request->ajax()
                    ? ResponseFormatter::error(
                        [
                            'error' => 'Unauthorized',
                        ],
                        'Mohon maaf email/password Anda tidak sesuai',
                        401,
                    )
                    : back()->withErrors($msg);
            }
        } catch (Exception $error) {
            Log::channel('exception')->info($error);
            if ($request->ajax()) {
                return ResponseFormatter::error($error, 'Terjadi kegagalan, silahkan coba beberapa saat lagi', 500);
            } else {
                return abort(500, $error);
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
