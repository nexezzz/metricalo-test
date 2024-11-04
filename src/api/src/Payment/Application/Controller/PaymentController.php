<?php

namespace App\Payment\Application\Controller;

use App\Payment\Application\Attribute\RouteAttribute;
use App\Payment\Application\Resource\PaymentResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PaymentController
{
    public function __construct(
        private PaymentResource $paymentResource
    ) {}

    #[RouteAttribute(
        path: "/payment/process/{provider}", 
        name: "payment_process", 
        method: "POST", 
        requirements: ['provider' => 'aci|shift4']
    )]
    public function process(Request $request): JsonResponse
    {
        return $this->paymentResource->processPayment(request: $request);
    }
}
