<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Products::create([
            'name' => 'Black Hoodie',
            'slug' => 'black-hoodie',
            'price_cents' => 19900,
            'stock' => 15,
            'description' => 'A comfortable black hoodie made from soft cotton fabric, perfect for everyday wear.',
            'image' => 'hoodie-black.png',
            'is_active' => true,
        ]);

        Products::create(
            [
                'name' => 'Blue Denim Jacket',
                'slug' => 'blue-denim-jacket',
                'price_cents' => 35900,
                'stock' => 5,
                'description' => 'Classic blue denim jacket with a modern fit, suitable for all seasons.',
                'image' => 'denim-jacket.png',
                'is_active' => true,
            ]
        );

        Products::create(
            [
                'name' => 'Graphic T-Shirt',
                'slug' => 'graphic-tshirt',
                'price_cents' => 9900,
                'stock' => 0,
                'description' => 'Casual graphic t-shirt with a bold print. Limited stock available.',
                'image' => 'tshirt-graphic.png',
                'is_active' => true,
            ]);

            Products::create(
            [
                'name' => 'Leather Wallet',
                'slug' => 'leather-wallet',
                'price_cents' => 14900,
                'stock' => 20,
                'description' => 'Slim leather wallet crafted from premium materials for daily use.',
                'image' => 'wallet-leather.png',
                'is_active' => true,
            ]);

            Products::create(
            [
                'name' => 'Stainless Steel Water Bottle',
                'slug' => 'stainless-water-bottle',
                'price_cents' => 7900,
                'stock' => 25,
                'description' => 'Eco-friendly stainless steel bottle that keeps drinks cold or hot for hours.',
                'image' => 'water-bottle.png',
                'is_active' => true,
            ]);
    }
}
