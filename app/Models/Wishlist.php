<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Auth\User as Authenticatable;

class Wishlist extends Authenticatable
{
    use HasFactory;
    protected $collection='wishlist';

    protected $guarded = ['id'];

    public $timestamps = false;
}
