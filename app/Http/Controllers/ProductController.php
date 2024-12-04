<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 1) // Only approved products
            ->orderBy('created_at', 'desc')
            ->with('category')
            ->latest()   // Sort by date
            ->get();

        return view('home', compact('products'));
    }
}