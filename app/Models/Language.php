<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Language extends Model
{
    protected $table = 'languages';

    public function countries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'countrylanguage', 'LanguageCode', 'CountryCode');
    }
}
