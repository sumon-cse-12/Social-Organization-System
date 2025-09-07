<?php

namespace Modules\Payments\Services\Gateway;
use Modules\Payments\Services\Gateway\PaymentGatewayInterface;
class OfflineGateway implements PaymentGatewayInterface
{
    protected $note;

    public function setCredentials(array $credentials): self
    {
        $this->note = $credentials['offlineNote'] ?? 'Pay using offline method.';
        return $this;
    }

    public function createOrder(float $amount, string $currency, string $returnUrl, string $cancelUrl): array
    {
        return [
            'status'  => 'pending',
            'message' => $this->note,
        ];
    }

    public function capturePayment(string $transactionReference): array
    {
        return [
            'status'  => 'manual',
            'message' => 'Payment to be confirmed offline',
        ];
    }

    public function refundPayment(string $transactionReference, float $amount, string $reason = null): array
    {
        return [
            'status'  => 'manual',
            'message' => 'Refund handled manually offline',
        ];
    }

    public function getPaymentDetails(string $transactionReference): array
    {
        return [
            'status'  => 'manual',
            'message' => 'Payment details are tracked offline',
        ];
    }
}
