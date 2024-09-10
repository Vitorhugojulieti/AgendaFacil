<?php
namespace app\classes;
class MercadoPagoIntegration
{
    private $accessToken;
    private $baseUrl = 'https://api.mercadopago.com';

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    private function request(string $method, string $endpoint, array $data = []): array
    {
        // Implement secure HTTP request using cURL or a Guzzle client
        // Validate and handle potential errors (e.g., curl_error, HTTP status codes)

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->accessToken
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, true);
    }

    public function createPreference(float $amount): array
    {
        $data = [
            'items' => [
                [
                    'title' => 'Dummy Title',
                    'description' => 'Dummy description',
                    // 'picture_url' => 'http://www.myapp.com/myimage.jpg', // Optional
                    // 'category_id' => 'car_electronics', // Optional
                    'quantity' => 1,
                    'currency_id' => 'BRL',
                    'unit_price' => $amount
                ]
            ],
            'back_urls' => [
                'success' => 'https://google.com/success',
                'pending' => 'https://google.com/pending',
                'failure' => 'https://google.com/failure'
            ],
            'notification_url' => 'https://google.com', // Optional
            'auto_return' => 'approved',
            'payment_methods' => [
                
            ]
        ];

        return $this->request('POST', '/checkout/preferences', $data);
    }

    public function createPayment(float $amount, int $externalReference): array|bool
    {
        $preference = $this->createPreference($amount);

        if (isset($preference['id'])) {
            return [
                'preference_id' => $preference['id'],
                'external_reference' => $externalReference
            ];
        } else {
            // Handle preference creation failure
            return false;
        }
    }
}