<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return response()->json(['languages' => $languages]);
    }

    public function show($id)
    {
        $language = Language::with('countries')->find($id);
        return response()->json(['language' => $language]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:languages',
            'code' => 'required|string|unique:languages',
        ]);

        $language = Language::create([
            'Name' => $request->get('name'),
            'Code' => $request->get('code'),
        ]);

        return response()->json(['language' => $language], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:languages,Name,' . $id,
            'code' => 'required|string|unique:languages,Code,' . $id,
        ]);

        $language = Language::find($id);
        $language->update([
            'Name' => $request->get('name'),
            'Code' => $request->get('code'),
        ]);

        return response()->json(['language' => $language]);
    }

    public function destroy($id)
    {
        Language::destroy($id);
        return response()->json(['message' => 'Language deleted successfully']);
    }
    public function getOfficialLanguages()
    {
        $countries = Country::with('officialLanguage')->get();
        return response()->json($countries);
    }
}

