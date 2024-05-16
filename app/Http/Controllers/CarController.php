<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Models\Brand;
use App\Models\CarType;
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

        $data = [
            'title' => 'Daftar Mobil | Rent Car',
            'currentNav' => 'car',
            'currentNavChild' => 'car',
        ];

        return view('car.index', $data);
    }

    // Get data car
    public function getCar(Request $request)
    {
        $cars = Car::with('brand:id,name', 'carType:id,name')->get();

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
            'title' => 'Tambah Mobil | Rent Car',
            'brands' => $brands,
            'carTypes' => $carTypes,
            'currentNav' => 'car',
            'currentNavChild' => 'addCar',
        ];

        return view('car.create', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
}
