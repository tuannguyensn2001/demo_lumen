<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $products = Product::all();

        return response()->json([
            'data' => $products
        ]);
    }
}
