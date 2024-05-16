<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Rent;
use App\Http\Requests\StoreRentRequest;
use App\Http\Requests\UpdateRentRequest;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Throw_;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Data Peminjaman Mobil | Rent Car',
            'currentNav' => 'rent',
            'currentNavChild' => 'index',
        ];

        return view('rent.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->has('car_id')) {
            $car = Car::find($request->car_id);
        }
        $data = [
            'title' => 'Daftar Mobil | Rent Car',
            'currentNav' => 'rent',
            'currentNavChild' => 'create',
            'car' => $car ?? null,
        ];

        return view('rent.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];

        $validated = Validator::make($request->all(), $rules);

        if ($validated->fails()) {
            return ResponseFormatter::error($validated->errors()->first(), 'Validation Error', 422);
        }

        // mengecek jika mobil tersedia
        $car = Car::find($request->car_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $checkRent = Rent::where('car_id', $request->car_id)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        try {
            DB::beginTransaction();
            if ($checkRent) {
                throw new \Exception('Mobil Tidak Tersedia');
            } else {
                // simpan data peminjaman
                $rent = Rent::create([
                    'car_id' => $request->car_id,
                    'user_id' => auth()->user()->id,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ]);

                DB::commit();
                return ResponseFormatter::success([
                    'redirect' => route('rent.index'),
                ], 'Peminjaman Berhasil');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error([
                'error' => $e->getMessage()
            ], 'Peminjaman Gagal', 500);
        }

        dd($checkRent);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRentRequest $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rent $rent)
    {
        //
    }
}
