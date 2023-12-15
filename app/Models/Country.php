<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Controllers\CityController;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // Asegúrate de tener la importación correcta
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Country extends Model
{
    protected $table = 'country';
    protected $primaryKey = 'Code';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'Code',
        'Name',
        'Continent',
        'Region',
        'SurfaceArea',
        'IndepYear',
        'Population',
        'LifeExpectancy',
        'GNP',
        'GNPOld',
        'LocalName',
        'GovernmentForm',
        'HeadOfState',
        'Capital',
        'Code2',
    ];

    // Relación con la tabla City
    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'CountryCode', 'Code');
    }

    // Relación con la tabla CountryLanguage

    public function officialLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'CountryCode', 'LanguageCode');
    }
}
