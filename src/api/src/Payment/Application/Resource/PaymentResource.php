<?php

namespace App\Payment\Application\Resource;

use App\Payment\Application\DTO\PaymentRequestDTO;
use App\Payment\Application\Request\ProcessPaymentRequest;
use App\Payment\Domain\Service\PaymentService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Payment\Domain\Exception\PaymentProcessingException;

class PaymentResource
{
    public function __construct(
        private PaymentService $paymentService,
        private ProcessPaymentRequest $processPaymentRequest
    ) {}

    public function processPayment(Request $request): JsonResponse
    {
        try {
            $provider = $request->get('provider');
            $data = json_decode($request->getContent(), true);

            // Build DTO and validate request
            $dto = new PaymentRequestDTO(
                provider: $provider,
                amount: $data['amount'] ?? null,
                currency: $data['currency'] ?? null,
                cardNumber: $data['card_number'] ?? null,
                cardExpYear: $data['card_exp_year'] ?? null,
                cardExpMonth: $data['card_exp_month'] ?? null,
                cardCVV: $data['card_cvv'] ?? null
            );

            $validationResponse = $this->processPaymentRequest->fromRequest($provider, $dto);
            if ($validationResponse instanceof JsonResponse) {
                return $validationResponse;
            }

            $transactionResponse = $this->paymentService->handlePayment($dto, $provider);

            return new JsonResponse([
                'transactionId' => $transactionResponse->getTransactionId(),
                'date_of_creating' => $transactionResponse->getCreatedAt(),
                'amount' => $transactionResponse->getAmount(),
                'currency' => $transactionResponse->getCurrency(),
                'card_bin' => $transactionResponse->getCardBin()
            ]);

        } catch (PaymentProcessingException $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'provider' => $provider
            ], Response::HTTP_BAD_REQUEST);

        } catch (\Throwable $e) {
            return new JsonResponse([
                'status' => 'error',
                'message' => 'An unexpected error occurred.',
                'code' => $e->getCode()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
