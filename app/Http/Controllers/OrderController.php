<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductStyle;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends BaseController
{
    public function createOrder(Request $request)
    {
        $data = $request->all();
        $order = Order::create($data);
        if ($order) {
            return $this->sendResponse('OK', 'Order create successful.');
        } else {
            return $this->sendResponse('Error', 'Order create failed.');
        }
    }

    public function createOrderDetail(Request $request)
    {
        $data = $request->all();
        $order = OrderDetail::create($data);
        if ($order) {
            return $this->sendResponse('OK', 'Order detail create successful.');
        } else {
            return $this->sendResponse('Error', 'Order detail create failed.');
        }
    }

    public function getListOrder(Request $request)
    {
        $page = $request->input('page') ?? 1;
        $perPage = $request->input('perPage') ?? 10;
        $orders = Order::get();
        $orders = new LengthAwarePaginator($orders->forPage($page, $perPage), $orders->count(), $perPage, $page);
        return $this->sendResponse($orders, 'Orders retrieved successfully.');
    }

    public function getOrderById($id)
    {
        $order = Order::where('id', $id)->get()->first();
        $products = OrderDetail::where('order_id', $id)->get();
        if (isset($products)) {
            foreach ($products as $product) {
                $p = Product::where('id', $product->product_id)->get()->first();
                $product->type = $p->option_type == 1 ? ProductColor::where("id", $product->product_detail_id)->get()->first() : ProductStyle::where("id", $product->product_detail_id)->get()->first();
            }
        }
        $order->detail = $products;
        return $this->sendResponse($order, 'Order retrieved successfully.');
    }
}
