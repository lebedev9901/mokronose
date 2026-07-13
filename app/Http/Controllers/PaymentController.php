<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\YooKassaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function create(
        Order $order,
        YooKassaService $yooKassaService
    )
    {

        // защита от повторной оплаты

        if ($order->payment_status === 'succeeded') {

            return redirect()
                ->route('orders.show', $order)
                ->with(
                    'success',
                    'Заказ уже оплачен'
                );

        }



        $payment = $yooKassaService
            ->createPayment($order);



        return redirect(
            $payment
                ->getConfirmation()
                ->getConfirmationUrl()
        );

    }





    public function success()
    {

        return view(
            'payment.success'
        );

    }





public function webhook(
    Request $request,
    YooKassaService $yooKassa
)
{
    $payload = $request->all();

    Log::info('YooKassa webhook', $payload);

    if (
        empty($payload['object']['id'])
    ) {

        return response()->json([
            'message' => 'Payment ID not found'
        ], 400);

    }

    $paymentId = $payload['object']['id'];

    $order = Order::where(
        'payment_id',
        $paymentId
    )->first();

    if (!$order) {

        Log::warning(
            'Order not found for payment',
            [
                'payment_id' => $paymentId
            ]
        );

        return response()->json([
            'message' => 'Order not found'
        ], 404);

    }

    $payment = $yooKassa
        ->getPayment($paymentId);

    $order->update([

        'payment_status' => $payment->getStatus(),

    ]);

    if (
        $payment->getStatus() === 'succeeded'
    ) {

        $order->update([

            'status' => 'confirmed',

        ]);

    }

    return response()->json([
        'status' => 'ok'
    ]);
}
}
