<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(){

        $products = Product::latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function edit(Product $product){

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product){

    }


}
