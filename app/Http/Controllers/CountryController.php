<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function show($id)
    {
        $country = Country::with('languages')->find($id);
        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }
        return response()->json(['country' => $country]);
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
    public function getCountriesByContinent($continent)
    {
        // Cambia 'Continent' a 'Region' si eso es lo que estás usando en tu base de datos
        $countries = Country::where('Continent', $continent)->get();

        if ($countries->isEmpty()) {
            // Cambia el mensaje de error si lo deseas
            return response()->json(['error' => 'No countries found for the given continent'], 404);
        }

        return response()->json(['countries' => $countries]);
    }
    public function getCountriesOrderedBySize()
    {
        $countries = Country::orderBy('SurfaceArea')->get(['Name', 'SurfaceArea']);

        return response()->json(['countries' => $countries]);
    }
    public function getCountriesWithoutCities()
    {
        $countries = Country::doesntHave('cities')->get(['Code', 'Name']);

        return response()->json(['countries' => $countries]);
    }
    public function getCountriesWithNullIndependence()
    {
        $countries = Country::whereNull('IndepYear')->get(['Code', 'Name']);

        return response()->json(['countries' => $countries]);
    }
    public function getCountriesByIndependenceYearRange($year1, $year2)
    {
        // Validar que $year1 y $year2 son años válidos (puedes agregar más validaciones según sea necesario)
        if (!is_numeric($year1) || !is_numeric($year2) || $year1 < 0 || $year2 < 0) {
            return response()->json(['error' => 'Año no válido'], 400);
        }

        $countries = Country::whereBetween('IndepYear', [$year1, $year2])->get(['Code', 'Name']);

        return response()->json(['countries' => $countries]);
    }
    public function getCountriesByLetter($letter)
    {
        // Validar que $letter sea una letra
        if (!ctype_alpha($letter) || strlen($letter) !== 1) {
            return response()->json(['error' => 'La letra debe ser un solo carácter alfabético'], 400);
        }

        $countries = Country::where('Name', 'like', $letter . '%')->get(['Code', 'Name']);

        return response()->json(['countries' => $countries]);
    }
    public function getCountryStats($code)
    {
        $country = Country::with('cities')->find($code);

        if (!$country) {
            return response()->json(['error' => 'Country not found'], 404);
        }

        $population = $country->cities->sum('Population');
        $avgPopulation = $population / $country->cities->count();

        return response()->json([
            'country' => $country->Name,
            'avgPopulation' => $avgPopulation,
            'numCities' => $country->cities->count(),
        ]);
    }
}
