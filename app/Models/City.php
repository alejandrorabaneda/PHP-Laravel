<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class City extends Model
{
    protected $table = 'city';

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'CountryCode', 'Code');
    }
}
