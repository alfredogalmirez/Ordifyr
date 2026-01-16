<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [ 'name', 'slug', 'price_cents', 'stock', 'description', 'image', 'is_active'];
}
