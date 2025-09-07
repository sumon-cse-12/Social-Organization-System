<?php

namespace Modules\Payments\Services\Gateway;

use Exception;
use Omnipay\Omnipay;
use Illuminate\Support\Facades\Log;
use Modules\Payments\Services\Gateway\PaymentGatewayInterface;

class StripeGateway implements PaymentGatewayInterface
{
    protected $gateway;

     public function setCredentials(array $credentials): self
    {
        $secretKey = $credentials['secret_key'] ?? $credentials['apiSecret'] ?? null;

        if (!$secretKey) {
            throw new Exception('Stripe secret key is required.');
        }

        $this->gateway = Omnipay::create('Stripe');
        $this->gateway->setApiKey($secretKey);

        return $this;
    }

    public function createOrder(float $amount, string $currency, string $returnUrl = null, string $cancelUrl = null): array
    {
        try {
            $response = $this->gateway->purchase([
                'amount' => number_format($amount, 2, '.', ''),
                'currency' => $currency,
                'source' => 'tok_visa', 
            ])->send();

            if ($response->isSuccessful()) {
                return [
                    'status' => 'completed',
                    'transaction_id' => $response->getTransactionReference(),
                    'data' => $response->getData(),
                ];
            }

            if ($response->isRedirect()) {
                return [
                    'approval_url' => $response->getRedirectUrl(),
                    'transaction_id' => $response->getTransactionReference(),
                    'status' => 'pending',
                ];
            }

            throw new Exception($response->getMessage() ?? 'Stripe purchase failed');

        } catch (Exception $e) {
            Log::error('Stripe createOrder error', ['message' => $e->getMessage()]);
            throw $e;
        }
    }

    public function capturePayment(string $transactionReference): array
    {
        $response = $this->gateway->completePurchase([
            'transactionReference' => $transactionReference,
        ])->send();

        return [
            'status' => $response->isSuccessful() ? 'completed' : 'failed',
            'transaction_id' => $response->getTransactionReference(),
            'data' => $response->getData(),
        ];
    }

    public function refundPayment(string $transactionReference, float $amount): array
    {
        $response = $this->gateway->refund([
            'transactionReference' => $transactionReference,
            'amount' => number_format($amount, 2, '.', ''),
        ])->send();

        return [
            'status' => $response->isSuccessful() ? 'refunded' : 'failed',
            'transaction_id' => $response->getTransactionReference(),
            'amount' => $response->getAmount(),
            'data' => $response->getData(),
        ];
    }

    public function getPaymentDetails(string $transactionReference): array
    {
        $response = $this->gateway->fetchTransaction([
            'transactionReference' => $transactionReference,
        ])->send();

        return [
            'status' => $response->getStatus(),
            'amount' => $response->getAmount(),
            'currency' => $response->getCurrency(),
            'transaction_id' => $response->getTransactionReference(),
            'data' => $response->getData(),
        ];
    }
}
