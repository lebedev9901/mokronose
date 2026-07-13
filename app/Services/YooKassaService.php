<?php

namespace App\Services;

use App\Models\Order;
use YooKassa\Client;

class YooKassaService
{
    protected Client $client;


    public function __construct()
    {
        $this->client = new Client();

        $this->client->setAuth(
            config('services.yookassa.shop_id'),
            config('services.yookassa.secret_key')
        );
    }


    /**
     * Создание платежа ЮKassa
     */
    public function createPayment(Order $order)
    {
        $order->load([
            'user',
            'items.product',
        ]);


        $receiptItems = $this->buildReceiptItems($order);


        $payment = $this->client->createPayment([

            'amount' => [

                'value' => number_format(
                    $order->total_after_discount,
                    2,
                    '.',
                    ''
                ),

                'currency' => 'RUB',

            ],


            'capture' => true,


            'confirmation' => [

                'type' => 'redirect',

                'return_url' => route('payment.success'),

            ],


            'description' => 'Заказ №'.$order->id,


            'receipt' => [

                'customer' => [

                    'email' => $order->user->email,

                    'phone' => $this->formatPhone(
                        $order->user->phone
                    ),

                ],


                'items' => $receiptItems,

            ],


            'metadata' => [

                'order_id' => $order->id,

            ],


        ], uniqid('', true));


        $order->update([

            'payment_id' => $payment->getId(),

            'payment_status' => $payment->getStatus(),

        ]);


        return $payment;
    }



    /**
     * Формирование товаров для чека
     */
    protected function buildReceiptItems(Order $order): array
    {

        $items = [];


        $totalBeforeDiscount = $order->total_before_discount;


        foreach ($order->items as $item) {


            $itemTotal = $item->price * $item->qty;


            /**
             * Распределяем скидку пропорционально
             */
            if ($totalBeforeDiscount > 0) {

                $discountCoefficient =
                    $order->total_after_discount
                    /
                    $totalBeforeDiscount;

            } else {

                $discountCoefficient = 1;

            }


            $finalPrice =
                $itemTotal
                *
                $discountCoefficient;



            $pricePerItem =
                $finalPrice / $item->qty;



            $items[] = [

                'description' => mb_substr(
                    $item->product->title,
                    0,
                    128
                ),


                'quantity' => number_format(
                    $item->qty,
                    2,
                    '.',
                    ''
                ),


                'amount' => [

                    'value' => number_format(
                        $pricePerItem,
                        2,
                        '.',
                        ''
                    ),

                    'currency' => 'RUB',

                ],


                // ИП УСН без НДС
                'vat_code' => 1,


                'payment_mode' => 'full_payment',


                'payment_subject' => 'commodity',

            ];

        }


        return $items;

    }



    /**
     * Получить ссылку на оплату
     */
    public function getConfirmationUrl(Order $order): string
    {

        $payment = $this->createPayment($order);


        return $payment
            ->getConfirmation()
            ->getConfirmationUrl();

    }



    /**
     * Получить информацию о платеже
     */
    public function getPayment(string $paymentId)
    {

        return $this->client
            ->getPaymentInfo($paymentId);

    }



    /**
     * Обновить статус заказа после webhook
     */
    public function updateOrderStatus(Order $order): void
    {

        $payment = $this->getPayment(
            $order->payment_id
        );


        $order->update([

            'payment_status' =>
                $payment->getStatus(),

        ]);



        if (
            $payment->getStatus()
            ===
            'succeeded'
        ) {


            $order->update([

                'status' => 'confirmed',

            ]);

        }

    }

    protected function formatPhone(?string $phone): ?string
{
    if (!$phone) {
        return null;
    }


    $phone = preg_replace(
        '/\D/',
        '',
        $phone
    );


    if (strlen($phone) === 11 && str_starts_with($phone, '8')) {

        $phone = '7' . substr($phone, 1);

    }


    if (strlen($phone) === 11 && str_starts_with($phone, '7')) {

        return '+' . $phone;

    }


    return null;
}
}