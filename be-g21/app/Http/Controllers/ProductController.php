<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductController extends BaseController
{
    public function index(Request $request)
    {
        $page = $request->input('page') ?? 1;
        $perPage = $request->input('perPage') ?? 10;
        $search = $request->input('search') ?? '';
        $products = Product::where('product_name', 'LIKE', "%$search%")->where('status', '=', 1)->with('category')->with('colors')->with('styles')->get();
        $products = new LengthAwarePaginator($products->forPage($page, $perPage), $products->count(), $perPage, $page);
        return $this->sendResponse($products, 'Products retrieved successfully.');
    }

    public function getProductById($id)
    {
        $product = Product::find($id)->get();
        return $this->sendResponse($product, 'Product retrieved successfully.');
    }

    public function getAllCategory()
    {
        $category = Category::all();
        return $this->sendResponse($category, 'Categorys retrieved successfully.');
    }

    public function getProductByCategoryId(Request $request)
    {
        $cateId = $request->cateId;
        $products = Category::find($cateId)->with('products')->get();
        return $this->sendResponse($products, 'Products retrieved successfully.');
    }

    public function updateProduct(Request $request)
    {
        $data = $request->data;
        $product = Product::find($request->id)->update($data->toArray());
        if ($product) {
            $this->sendResponse($product, 'Product update successful.');
        } else {
            $this->sendResponse('Error', 'Product update failed.');
        }
    }
}
