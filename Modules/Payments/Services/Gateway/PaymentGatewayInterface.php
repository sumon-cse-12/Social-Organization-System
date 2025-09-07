<?php

namespace Modules\Payments\Services\Gateway;

interface PaymentGatewayInterface
{
    public function setCredentials(array $credentials): self;

    public function createOrder(float $amount, string $currency, string $returnUrl, string $cancelUrl): array;

    public function capturePayment(string $transactionReference): array;

    public function refundPayment(string $transactionReference, float $amount): array;

    public function getPaymentDetails(string $transactionReference): array;
}
