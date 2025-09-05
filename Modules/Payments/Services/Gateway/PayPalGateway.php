<?php

namespace Modules\Payments\Services\Gateway;

use Exception;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalGateway implements PaymentGatewayInterface
{

    protected PayPalClient $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
    }

    public function setCredentials(array $credentials): self
    {
        // expects: ['mode' => 'sandbox|live', 'apiKey' => 'client_id', 'apiSecret' => 'client_secret']
        $config = [
            'mode' => $credentials['mode'] ?? 'sandbox',
            'sandbox' => [
                'client_id' => $credentials['apiKey'] ?? '',
                'client_secret' => $credentials['apiSecret'] ?? '',
            ],
            'live' => [
                'client_id' => $credentials['apiKey'] ?? '',
                'client_secret' => $credentials['apiSecret'] ?? '',
            ],
        ];
        $this->provider->setApiCredentials($config);
        $this->provider->getAccessToken();
        return $this;
    }

    public function createOrder(float $amount, string $currency, string $returnUrl, string $cancelUrl): array
    {
        $order = $this->provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => $currency,
                    'value' => number_format($amount, 2, '.', ''),
                ],
            ]],
            'application_context' => [
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl,
            ],
        ]);

        $approvalUrl = collect($order['links'] ?? [])
            ->firstWhere('rel', 'approve')['href'] ?? null;

        if (!$approvalUrl || empty($order['id'])) {
            throw new Exception('PayPal approval URL not found.');
        }

        return ['approval_url' => $approvalUrl, 'order_id' => $order['id']];
    }

    public function capturePayment(string $orderToken): array
    {
        $response = $this->provider->capturePaymentOrder($orderToken);

        $capture = data_get($response, 'purchase_units.0.payments.captures.0');
        return [
            'capture_id' => data_get($capture, 'id'),
            'status'     => data_get($capture, 'status', data_get($response, 'status', 'UNKNOWN')),
            'raw'        => $response,
        ];
    }

    public function refund(string $captureId, ?float $amount = null, string $currency = 'USD'): array
    {
        $payload = [];
        if ($amount) {
            $payload['amount'] = [
                'value' => number_format($amount, 2, '.', ''),
                'currency_code' => $currency,
            ];
        }

        $response = $this->provider->refundCapturedPayment($captureId, $payload);

        return [
            'refund_id' => data_get($response, 'id'),
            'status'    => data_get($response, 'status', 'UNKNOWN'),
            'raw'       => $response,
        ];
    }
}
