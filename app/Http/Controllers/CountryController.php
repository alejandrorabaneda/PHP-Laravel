<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return response()->json($countries);
    }

    public function getByName($name)
    {
        $country = Country::where('Name', $name)->first();

        if ($country) {
            return response()->json(['country' => $country]);
        } else {
            return response()->json(['message' => 'Country not found'], 404);
        }
    }

    public function show($code)
    {
        $country = Country::with('cities')->where('Code', $code)->first();
        if ($country) {
            return response()->json(['country' => $country]);
        } else {
            return response()->json(['message' => 'Country not found'], 404);
        }
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            // Puedes agregar más reglas de validación según tus necesidades
            'Code' => 'required|string|max:3|unique:countries,Code',
            'Name' => 'required|string',
            'Continent' => 'required|in:Asia,Europe,North America,Africa,Oceania,Antarctica,South America',
            'Region' => 'required|string',
            'SurfaceArea' => 'required|numeric',
            'IndepYear' => 'nullable|integer',
            'Population' => 'required|integer',
            'LifeExpectancy' => 'nullable|numeric',
            'GNP' => 'nullable|numeric',
            'GNPOld' => 'nullable|numeric',
            'LocalName' => 'required|string',
            'GovernmentForm' => 'required|string',
            'HeadOfState' => 'nullable|string',
            'Capital' => 'nullable|integer',
            'Code2' => 'required|string|max:2',
        ]);

        $country = Country::create($request->all());

        return response()->json($country, 201);
    }

    public function update(Request $request, $code)
    {
        $this->validate($request, [
            // Puedes agregar más reglas de validación según tus necesidades
            'Name' => 'required|string',
            'Continent' => 'required|in:Asia,Europe,North America,Africa,Oceania,Antarctica,South America',
            'Region' => 'required|string',
            'SurfaceArea' => 'required|numeric',
            'IndepYear' => 'nullable|integer',
            'Population' => 'required|integer',
            'LifeExpectancy' => 'nullable|numeric',
            'GNP' => 'nullable|numeric',
            'GNPOld' => 'nullable|numeric',
            'LocalName' => 'required|string',
            'GovernmentForm' => 'required|string',
            'HeadOfState' => 'nullable|string',
            'Capital' => 'nullable|integer',
            'Code2' => 'required|string|max:2',
        ]);

        $country = Country::find($code);

        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $country->update($request->all());

        return response()->json($country, 200);
    }

    public function destroy($code)
    {
        $country = Country::find($code);

        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $country->delete();

        return response()->json(null, 204);
    }
}
