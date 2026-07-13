<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\YooKassaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class YooKassaWebController extends Controller
{
    public function handle(
        Request $request,
        YooKassaService $yooKassa
    ) {

        Log::info('YooKassa webhook', [
            'data' => $request->all()
        ]);


        $event = $request->input('event');


        if ($event !== 'payment.succeeded') {
            return response()->json([
                'status' => 'ignored'
            ]);
        }


        $payment = $request->input('object');


        $orderId = $payment['metadata']['order_id'] ?? null;


        if (!$orderId) {
            return response()->json([
                'error' => 'order id missing'
            ], 400);
        }


        $order = Order::find($orderId);


        if (!$order) {
            return response()->json([
                'error' => 'order not found'
            ], 404);
        }


        $order->update([
            'payment_status' => 'succeeded',
            'status' => 'confirmed',
        ]);


        Log::info('Order payment confirmed', [
            'order_id' => $order->id
        ]);


        return response()->json([
            'status' => 'ok'
        ]);
    }
}
