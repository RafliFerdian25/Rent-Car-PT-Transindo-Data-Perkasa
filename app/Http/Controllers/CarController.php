<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::select('id', 'name')->get();
        $carTypes = CarType::select('id', 'name')->get();
        $data = [
            'title' => 'Daftar Mobil | Rent Car',
            'brands' => $brands,
            'carTypes' => $carTypes,
            'currentNav' => 'car',
            'currentNavChild' => 'car',
        ];

        return view('car.index', $data);
    }

    // Get data car
    public function getCar(Request $request)
    {
        if ($request->filterStartDate || $request->filterEndDate) {
            if (!$request->filterStartDate || !$request->filterEndDate) {
                return ResponseFormatter::error([
                    'error' => 'Tanggal mulai dan tanggal selesai harus diisi'
                ], 'Validasi gagal', 422);
            }
        }

        $cars = Car::with('brand:id,name', 'carType:id,name', 'rents')
            ->when($request->filterBrand, function ($query) use ($request) {
                $query->where('brand_id', $request->filterBrand);
            })
            ->when($request->filterCarType, function ($query) use ($request) {
                $query->where('car_type_id', $request->filterCarType);
            })
            ->when($request->filterStartDate && $request->filterEndDate, function ($query) use ($request) {
                $startDate = Carbon::parse($request->filterStartDate);
                $endDate = Carbon::parse($request->filterEndDate);
                $query->whereDoesntHave('rents', function ($query) use ($startDate, $endDate) {
                    $query->where(function ($query) use ($startDate, $endDate) {
                        $query->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate]);
                    });
                });
            })
            ->get();

        return ResponseFormatter::success([
            'cars' => $cars
        ], 'Data mobil berhasil diambil');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::select('id', 'name')->get();
        $carTypes = CarType::select('id', 'name')->get();
        $data = [
            'title' => 'Tambah Mobil | Rent Car',
            'brands' => $brands,
            'carTypes' => $carTypes,
            'currentNav' => 'car',
            'currentNavChild' => 'addCar',
        ];

        return view('car.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'car_type_id' => 'required|exists:car_types,id',
            'rental_rate' => 'required|numeric',
            'license_plate' => 'required|string',
        ];

        $validated = Validator::make($request->all(), $rules);

        if ($validated->fails()) {
            return ResponseFormatter::error([
                'message' => $validated->errors()->first()
            ], 'Validasi gagal', 422);
        }

        try {
            DB::beginTransaction();
            $car = Car::create($request->all());

            DB::commit();

            return ResponseFormatter::success([
                'redirect' => route('car.index'),
            ], 'Data mobil berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Data mobil gagal ditambahkan', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        $brands = Brand::select('id', 'name')->get();
        $carTypes = CarType::select('id', 'name')->get();
        $data = [
            'title' => 'Ubah Mobil | Rent Car',
            'car' => $car,
            'brands' => $brands,
            'carTypes' => $carTypes,
            'currentNav' => 'car',
            'currentNavChild' => 'editCar',
        ];

        return view('car.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {

        $rules = [
            'name' => 'required|string',
            'brand_id' => 'required|exists:brands,id',
            'car_type_id' => 'required|exists:car_types,id',
            'rental_rate' => 'required|numeric',
            'license_plate' => 'required|string',
        ];

        $validated = Validator::make($request->all(), $rules);

        if ($validated->fails()) {
            return ResponseFormatter::error([
                'message' => $validated->errors()->first()
            ], 'Validasi gagal', 422);
        }

        try {
            DB::beginTransaction();
            // ubah data mobil
            $car->update($request->all());

            DB::commit();
            return ResponseFormatter::success([
                'redirect' => route('car.index'),
            ], 'Data mobil berhasil diubah');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Data mobil gagal diubah', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        try {
            DB::beginTransaction();
            $car->delete();

            DB::commit();
            return ResponseFormatter::success([
                'redirect' => route('car.index'),
            ], 'Data mobil berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return ResponseFormatter::error([
                'message' => $e->getMessage()
            ], 'Data mobil gagal dihapus', 500);
        }
    }
}
