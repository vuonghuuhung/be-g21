<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

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
}
