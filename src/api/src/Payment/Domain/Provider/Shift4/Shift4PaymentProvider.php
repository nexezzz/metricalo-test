<?php
namespace App\Payment\Domain\Provider\Shift4;

use App\Payment\Application\DTO\PaymentResponseDTO;
use App\Payment\Domain\Exception\PaymentProcessingException;
use App\Payment\Domain\Provider\PaymentProviderInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Shift4PaymentProvider implements PaymentProviderInterface
{
    private HttpClientInterface $httpClient;
    private string $apiKey;
    private string $apiUrl;

    public function __construct(HttpClientInterface $httpClient, string $apiKey, string $apiUrl)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    public function processPayment(float $amount, string $currency, string $cardNumber, string $cardExpMonth, string $cardExpYear, string $cardCVV): PaymentResponseDTO
    {
        try {
            $headers = [
                'Authorization' => 'Basic ' . base64_encode($this->apiKey . ':'),
                'Content-Type'  => 'application/json',
            ];

            $requestData = [
                'amount' => $amount,
                'currency' => $currency,
                'card' => [
                    'number' => $cardNumber,
                    "expMonth" => $cardExpMonth,
                    "expYear" => $cardExpYear,
                    "cvc" => $cardCVV
                ],
            ];

            $response = $this->httpClient->request('POST', $this->apiUrl, [
                'headers' => $headers,
                'json' => $requestData
            ]);

            $data = $response->toArray();
        } catch (\Exception $e) {
            throw new PaymentProcessingException("Failed to process payment: " . $e->getMessage(), 0, $e);
        }

        return new PaymentResponseDTO(
            $data['id'],
            (new \DateTime())->setTimestamp($data['created']),
            $data['amount'],
            $data['currency'],
            substr($cardNumber, 0, 4)
        );
    }
}
