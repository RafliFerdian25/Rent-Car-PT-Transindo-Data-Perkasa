<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create()
    {
        $data = [
            'title' => 'Register | Rent Car',
        ];
        return view('auth.register', $data);
    }

    public function store(Request $request)
    {
        // Validasi form
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'name' => 'required|min:3',
            'address' => 'required',
            'phone' => 'required|numeric|min:10|unique:users',
            'driving_license' => 'required|numeric|min:14|unique:users',
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
                : back()->with(['error' => $validator->errors()]);
        }

        try {
            DB::beginTransaction();
            // create user
            $user = User::create([
                'address' => $request->address,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hash::make() untuk mengenkripsi password
                'role' => 'customer',
                'name' => $request->name,
                'phone' => $request->phone,
                'driving_license' => $request->driving_license,
            ]);

            // berhasil membuat user
            if ($user) {
                DB::commit();
                return ResponseFormatter::success(
                    [
                        'redirect' => route('login'),
                    ],
                    'Pendaftaran berhasil',
                );
            }
        } catch (\Exception $e) {
            // gagal membuat user
            DB::rollBack();
            return ResponseFormatter::error(
                [
                    'error' => $e->getMessage(),
                ],
                'Pendaftaran gagal',
                500,
            );
        }
    }
}
