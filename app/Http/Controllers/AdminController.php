<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $lowStockThreshold = 5;

        $lowStockProducts = Product::where('stock', '<=', $lowStockThreshold)->orderBy('stock')->take(10)->get();

        $stats = [
            'totalProducts' => Product::count(),
            'lowStockCount' => Product::where('stock', '<=', $lowStockThreshold)->count(),
            'totalOrders' => 0,
            'pendingOrders' => 0,
        ];

        return view('admin.dashboard', compact('stats', 'lowStockProducts'));
    }
}
