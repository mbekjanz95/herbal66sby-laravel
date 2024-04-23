<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Authenticatable
{
    use HasFactory;
    // protected $guarded = [];

    // public function province(): BelongsTo
    // {
    //     return $this->belongsTo(Province::class);
    // }

    protected $collection='cities';

    protected $guarded = ['id'];
}
