<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index(){

        $products = Product::latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create(){
        return view('admin.products.create');
    }

    public function store(Request $request){
         $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|decimal:0,2|gte:0',
            'stock' => 'required|integer|gte:0',
        ]);

        Product::create([
            'name' => $validated['name'],
            'price_cents' => $validated['price'],
            'stock' => $validated['stock'],
        ]);

        return back()->with('success', 'Product added successfuly.');
    }

    public function edit(Product $product){

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|gte:0',
            'stock' => 'required|integer|gte:0',
        ]);

        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'stock' => $validated['stock'],
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }


}
