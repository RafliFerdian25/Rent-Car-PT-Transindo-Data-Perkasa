<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Car;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
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
