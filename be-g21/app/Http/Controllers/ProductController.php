<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductStyle;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Cloudinary\Cloudinary;

class ProductController extends BaseController
{
    public function uploadImage(Request $request)
    {
        $cloudinary = new Cloudinary(
            [
                'cloud' => [
                    'cloud_name' => 'dqejrpzru',
                    'api_key'    => '225848987484184',
                    'api_secret' => 'BU0OvW75xQ7R-_EHttHjh1dcSV0',
                ],
            ]
        );
        if ($request->hasFile('image_product')) {
            $image = $cloudinary->uploadApi()->upload($request->file('image_product')->getRealPath());
            return $this->sendResponse($image, 'Image retrieved successfully.');
        }
    }

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
        $product = Product::where('id', $id)->get()->first();
        $product->type = $product->option_type == 1 ? ProductColor::where("product_id", $id)->where('status', '=', 1)->get() : ProductStyle::where("product_id", $id)->where('status', '=', 1)->get();
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

    public function updateProduct($id, Request $request)
    {
        $data = $request->all();
        $product = Product::where('id', $id)->update($data);
        if ($product) {
            return $this->sendResponse('OK', 'Product update successful.');
        } else {
            return $this->sendResponse('Error', 'Product update failed.');
        }
    }

    public function createCategory(Request $request)
    {
        $data = $request->all();
        $category = Category::create($data);
        if ($category) {
            return $this->sendResponse('OK', 'Category create successful.');
        } else {
            return $this->sendResponse('Error', 'Category create failed.');
        }
    }

    public function createProduct(Request $request)
    {
        $data = $request->all();
        $product = Product::create($data);
        if ($product) {
            return $this->sendResponse($product->id, 'Category create successful.');
        } else {
            return $this->sendResponse($product->id, 'Category create failed.');
        }
    }

    public function getStyleById($id)
    {
        $style = ProductStyle::where('id', $id)->get()->first();
        return $this->sendResponse($style, 'Style retrieved successfully.');
    }

    public function getColorById($id)
    {
        $style = ProductColor::where('id', $id)->get()->first();
        return $this->sendResponse($style, 'Style retrieved successfully.');
    }

    public function updateStyle($id, Request $request)
    {
        $data = $request->all();
        $product = ProductStyle::where('id', $id)->update($data);
        if ($product) {
            return $this->sendResponse('OK', 'Product style update successful.');
        } else {
            return $this->sendResponse('Error', 'Product style update failed.');
        }
    }

    public function updateColor($id, Request $request)
    {
        $data = $request->all();
        $product = ProductColor::where('id', $id)->update($data);
        if ($product) {
            return $this->sendResponse('OK', 'Product color update successful.');
        } else {
            return $this->sendResponse('Error', 'Product color update failed.');
        }
    }

    public function createStyle(Request $request)
    {
        $data = $request->all();
        $style = ProductStyle::create($data);
        if ($style) {
            return $this->sendResponse('OK', 'Style create successful.');
        } else {
            return $this->sendResponse('Error', 'Style create failed.');
        }
    }

    public function createColor(Request $request)
    {
        $data = $request->all();
        $style = ProductColor::create($data);
        if ($style) {
            return $this->sendResponse('OK', 'Color create successful.');
        } else {
            return $this->sendResponse('Error', 'Color create failed.');
        }
    }
}
