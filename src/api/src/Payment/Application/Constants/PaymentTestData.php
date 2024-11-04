<?php

namespace App\Payment\Application\Constants;

class PaymentTestData
{
    public const DATA_ACI = [
        'amount' => 66.11,
        'currency' => 'EUR',
        'card_number' => '4200000000000000',
        'card_exp_year' => '2034',
        'card_exp_month' => '05',
        'card_cvv' => '123'
    ];

    public const DATA_SHIFT4 = [
        'amount' => 55.11,
        'currency' => 'MKD',
        'card_number' => '4242424242424242',
        'card_exp_year' => '25',
        'card_exp_month' => '11',
        'card_cvv' => '123'
    ];
}
