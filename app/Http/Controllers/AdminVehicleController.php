<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Category;

class AdminVehicleController extends Controller
{

    public function index()
    {
        $vehicles = Vehicle::with('category')->get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.vehicles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'license_plate' => 'required|string|unique:vehicles',
            'price_per_day' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle added successfully.');
    }

    public function edit(Vehicle $vehicle)
    {
        $categories = Category::all();
        return view('admin.vehicles.edit', compact('vehicle', 'categories'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $data = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'license_plate' => 'required|string|unique:vehicles,license_plate,' . $vehicle->id,
            'price_per_day' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle deleted successfully.');
    }
}
