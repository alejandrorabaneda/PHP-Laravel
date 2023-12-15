<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryLanguage extends Model
{
    protected $table = 'countrylanguage';
    public $timestamps = false;

    protected $fillable = [
        'CountryCode',
        'Language',
        'IsOfficial',
        'Percentage',
    ];

    // Relación con la tabla Country
    public function country()
    {
        return $this->belongsTo(Country::class, 'CountryCode', 'Code');
    }
}
