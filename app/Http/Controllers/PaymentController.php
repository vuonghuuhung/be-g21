<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $order_data = $request->input('order');
        $order = Order::create($order_data);
        $order_id = $order->id;
        $order_detail_data = $request->input('order-detail');
        foreach ($order_detail_data as &$detail) {
            $detail['order_id'] = $order_id;
        }
        foreach ($order_detail_data as &$detail) {
            OrderDetail::create($detail);
        }
        $vnp_TmnCode = env('VNP_TMNCODE '); //Mã website tại VNPAY 
        $vnp_HashSecret = env('VNP_HASHSECRET '); //Chuỗi bí mật
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = env('VNP_RETURN_URL');
        $vnp_TxnRef = $order_id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
        $vnp_OrderType = '250000';
        $vnp_Amount = $request->input('order.total_price') * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return response()->json([
            'redirectUrl' => $vnp_Url,
        ]);
    }

    public function handlePaymentResult(Request $request)
    {
        $data_payment = [
            'order_id' => $request->input('vnp_TxnRef'),
            'response_code' => $request->input('vnp_ResponseCode'),
            'transaction_no' => $request->input('vnp_TransactionNo'),
            'amount' => $request->input('vnp_Amount')
        ];
        $payment = Payment::create($data_payment);
        $url = env('FE_PAYMENT_RESULT_URL') . $payment->id;
        if ($request->vnp_ResponseCode == "00") {
            return redirect($url)->with('success', 'Đã thanh toán phí dịch vụ');
        }
        session()->forget('url_prev');
        return redirect($url)->with('errors', 'Lỗi trong quá trình thanh toán phí dịch vụ');
    }

    public function checkStatus(Request $request)
    {
        $payment = Payment::find($request->input('id'));

        if (!$payment) {
            return response()->json(['error' => 'Không tìm thấy bản ghi'], 404);
        }

        return response()->json(['payment' => $payment]);
    }
}
