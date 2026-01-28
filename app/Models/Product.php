<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    protected $fillable = ['name', 'slug', 'price_cents', 'stock', 'description', 'image', 'is_active'];

    protected static function booted(): void {
        static::creating(function (Product $product){
            if(!empty($product->slug)){
                return;
            }

            $base = Str::slug($product->name);
            $slug = $base;
            $i = 2;

            while(static::where('slug', $slug)->exists()){
                $slug = $base . '-' . $i;
                $i++;
            }

            $product->slug = $slug;
        });
    }

    public function getPriceAttribute()
    {
        return $this->price_cents / 100;
    }
}
