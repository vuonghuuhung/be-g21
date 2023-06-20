<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductStyle;
use App\Models\User;
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
            return $this->sendError('Error', 'Order create failed.');
        }
    }

    public function createOrderDetail(Request $request)
    {
        $data = $request->all();
        $order = OrderDetail::create($data);
        if ($order) {
            return $this->sendResponse('OK', 'Order detail create successful.');
        } else {
            return $this->sendError('Error', 'Order detail create failed.');
        }
    }

    public function getListOrder(Request $request)
    {
        $page = $request->input('page') ?? 1;
        $perPage = $request->input('perPage') ?? 10;
        $search = $request->input('search') ?? '';
        $orders = Order::where('status', '!=', 5)->where('id', 'LIKE', "%$search%")->get();
        $orders = new LengthAwarePaginator($orders->forPage($page, $perPage), $orders->count(), $perPage, $page);
        return $this->sendResponse($orders, 'Orders retrieved successfully.');
    }

    public function getOrderById($id)
    {
        $order = Order::where('status', '!=', 5)->where('id', $id)->with('user')->get()->first();
        $products = OrderDetail::where('order_id', $id)->get();
        if (isset($products)) {
            foreach ($products as $product) {
                $p = Product::where('id', $product->product_id)->get()->first();
                $product->type = $p->option_type == 1 ? ProductColor::where("id", $product->product_detail_id)->get()->first() : ProductStyle::where("id", $product->product_detail_id)->get()->first();
                $product->info = $p;
            }
        }
        $order->detail = $products;
        return $this->sendResponse($order, 'Order retrieved successfully.');
    }

    public function updateOrder($id, Request $request)
    {
        $data = $request->all();
        $order = Order::where('id', $id)->update($data);
        if ($order) {
            return $this->sendResponse('OK', 'Order update successful.');
        } else {
            return $this->sendError('Error', 'Order update failed.');
        }
    }

    public function analysis()
    {

        $order = Order::get()->count();
        $sum = Order::sum('total_price');
        $product = Product::get()->count();
        $style = ProductStyle::get()->count() + ProductColor::get()->count();
        $user = User::get()->count();
        $admin = User::where('status', 2)->get()->count();
        return $this->sendResponse(['order' => $order, 'sum' => $sum, 'product' => $product, 'style' => $style, 'user' => $user, 'admin' => $admin], 'Analysis retrieved successfully.');
    }

    public function getOrderByUserId($id, Request $request)
    {
        if ($request->user()->id != $id) {
            return $this->sendError('Order retrieved failed.');
        } else {
            $orders = Order::where('status', '!=', 5)->where('user_id', $id)->with('user')->get();
            foreach ($orders as $order) {
                $products = OrderDetail::where('order_id', $id)->get();
                if (isset($products)) {
                    foreach ($products as $product) {
                        $p = Product::where('id', $product->product_id)->get()->first();
                        $product->type = $p->option_type == 1 ? ProductColor::where("id", $product->product_detail_id)->get()->first() : ProductStyle::where("id", $product->product_detail_id)->get()->first();
                        $product->info = $p;
                    }
                }
                $order->detail = $products;
            }
            return $this->sendResponse($orders, 'Order retrieved successfully.');
        }
    }

    public function rateProduct($id, Request $request)
    {

        $data = $request->all();
        $p = OrderDetail::where('id', $id)->update($data);
        if ($p) {
            return $this->sendResponse('OK', 'Product rate update successful.');
        } else {
            return $this->sendError('Error', 'Product rate update failed.');
        }
    }
}
