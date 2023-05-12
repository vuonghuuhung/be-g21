<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::with('category')->get();
        return $this->sendResponse($products, 'Products retrieved successfully.');
    }
}
