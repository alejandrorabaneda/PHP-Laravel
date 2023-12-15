<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Country;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return response()->json(['cities' => $cities]);
    }

    public function show($id)
    {
        $city = City::findOrFail($id);
        $country = $city->country; // Accede a la relación country
        return response()->json(['city' => $city, 'country' => $country]);
    }

    public function create()
    {
        $countries = Country::all();
        return response()->json(['countries' => $countries]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required',
            'CountryCode' => 'required',
            'District' => 'required',
            'Population' => 'required'
        ]);

        // Verifica si el país existe antes de crear la ciudad
        $country = Country::where('Code', $request->input('CountryCode'))->first();

        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $city = City::create($request->all());

        return response()->json(['message' => 'City created successfully', 'city' => $city]);
    }

    public function edit($id)
    {
        $city = City::findOrFail($id);
        $countries = Country::all();
        return response()->json(['city' => $city, 'countries' => $countries]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'required',
            'CountryCode' => 'required',
            'District' => 'required',
            'Population' => 'required'
        ]);

        $country = Country::where('Code', $request->input('CountryCode'))->first();

        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $city = City::findOrFail($id);
        $city->update($request->all());

        return response()->json(['message' => 'City updated successfully', 'city' => $city]);
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        return response()->json(['message' => 'City deleted successfully']);
    }
}
