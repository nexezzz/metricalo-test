<?php

namespace App\Payment\Domain\Provider\ACI;

use App\Payment\Application\DTO\PaymentResponseDTO;
use App\Payment\Domain\Exception\PaymentProcessingException;
use App\Payment\Domain\Provider\PaymentProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ACIPaymentProvider implements PaymentProviderInterface
{
    private HttpClientInterface $httpClient;
    private string $apiKey;
    private string $entityId;
    private string $apiUrl;

    public function __construct(HttpClientInterface $httpClient, string $apiKey, string $entityId, string $apiUrl)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->entityId = $entityId;
    }

    public function processPayment(float $amount, string $currency, string $cardNumber, string $cardExpMonth, string $cardExpYear, string $cardCVV): PaymentResponseDTO
    {
        try {
            $headers = [
                'Authorization' => 'Bearer ' . $this->apiKey,
            ];

            $requestData = [
                'entityId' => $this->entityId,
                'amount' => number_format($amount, 2, '.', ''),
                'currency' => $currency,
                'paymentBrand' => 'VISA',
                'paymentType' => 'PA',
                'card.number' => $cardNumber,
                'card.holder' => 'Jane Jones',
                'card.expiryMonth' => $cardExpMonth,
                'card.expiryYear' => $cardExpYear,
                'card.cvv' => $cardCVV,
            ];

            $response = $this->httpClient->request('POST', $this->apiUrl, [
                'headers' => $headers,
                'body' => http_build_query($requestData),
            ]);

            $data = $response->toArray();
        } catch (\Exception $e) {
            throw new PaymentProcessingException("Failed to process payment: " . $e->getMessage(), 0, $e);
        }

        return new PaymentResponseDTO(
            transactionId: $data['id'] ?? null,
            createdAt: new \DateTime(),
            amount: $data['amount'] ?? null,
            currency: $data['currency'] ?? null,
            cardBin: substr($cardNumber, 0, 4)
        );
    }
}
