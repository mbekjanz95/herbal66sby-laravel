<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
