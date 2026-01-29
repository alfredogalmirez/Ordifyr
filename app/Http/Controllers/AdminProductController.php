<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $validated['name'],
            'price_cents' => round($validated['price'] * 100),
            'stock' => $validated['stock'],
            'image' => $imagePath,
        ]);

        return redirect('/admin/products')->with('success', 'Product added successfuly.');
    }

    public function edit(Product $product){

        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product){
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|decimal:0,2|gte:0',
            'stock' => 'required|integer|gte:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $product->image;

        if($request->hasFile('image')){
            if($product->image){
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $validated['name'],
            'price_cents' => round($validated['price'] * 100),
            'stock' => $validated['stock'],
        ]);

        return redirect('/admin/products')->with('success', 'Product updated successfully.');
    }


}
