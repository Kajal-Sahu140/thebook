<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;


class FibPaymentService
{
    protected $client;
    protected $authUrl;
    protected $paymentUrl;
    protected $processPaymentUrl;
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->client = new Client();
        $this->authUrl = 'https://fib.stage.fib.iq/auth/realms/fib-online-shop/protocol/openid-connect/token';
        $this->paymentUrl = 'https://fib.stage.fib.iq/protected/v1/payments';
        $this->processPaymentUrl = 'https://fib.stage.fib.iq/protected/v1/payments/process';
        $this->clientId = env('FIB_CLIENT_ID', 'baby-center');
        $this->clientSecret = env('FIB_CLIENT_SECRET', '77c2f6fb-f1d5-4872-81e6-703176164e91');
    }

    /**
     * Get Access Token from FIB API
     */
    public function getAccessToken()
    {
        try {
            $response = $this->client->post($this->authUrl, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ],
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return $data['access_token'] ?? null;
        } catch (RequestException $e) {
            return null;
        }
    }

    /**
     * Initiate a Payment
     */
    public function initiatePayment($amount, $currency, $callbackUrl, $description)
    {
        
        $token = $this->getAccessToken();
        //dd($amount);
        if (!$token) {
            return ['error' => 'Access token missing'];
        }
        // dd($amount.$currency.$callbackUrl.$description);
        try {
                $response = $this->client->post($this->paymentUrl, [
                'json' => [
                     'monetaryValue' => [
                        'amount' => round($amount, 1),  // Ensure two decimal places
                        'currency' => trim($currency),  // Remove any accidental spaces
                    ],
                    'statusCallbackUrl' => rtrim($callbackUrl, '/'),  // Remove trailing slash
                    'description' => substr($description, 0, 255),  // Ensure max length
                    'expiresIn' => 'PT24H',  // Use simpler format
                    'category' => 'POS',
                    'refundableFor' => 'PT24H',
                ],
               'headers' => [
                    'Authorization' => 'Bearer ' . $this->getAccessToken(),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]);
            //   dd($response);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            dd($e);
            return ['error' => 'Payment request failed', 'message' => $e->getMessage()];
        }
    }

    /**
     * Check Payment Status
     */
    public function checkPaymentStatus($paymentId)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return ['error' => 'Access token missing'];
        }

        try {
            $response = $this->client->get("{$this->paymentUrl}/{$paymentId}/status", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
            ]);
                // dd($response);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ['error' => 'Failed to get payment status', 'message' => $e->getMessage()];
        }
    }

    /**
     * Send Payment Using Readable Code
     */
 

}
