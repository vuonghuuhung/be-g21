<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::with('category')->get();
        return $this->sendResponse($products, 'Products retrieved successfully.');
    }
}
