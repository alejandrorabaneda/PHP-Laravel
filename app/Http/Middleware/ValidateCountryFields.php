<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateCountryFields
{
    public function handle(Request $request, Closure $next)
    {
        $rules = [
            'Code' => 'required|string|max:3',
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
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        return $next($request);
    }
}
