<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Auth\User as Authenticatable;

class Produk extends Authenticatable
{
    use HasFactory;
    protected $collection='produk';

    protected $guarded = ['id'];

    public $timestamps = false;
}
