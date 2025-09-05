<?php

namespace Modules\Payments\Services\Gateway;

interface PaymentGatewayInterface
{

   public function setCredentials(array $credentials): self;

    /** return array{approval_url:string, order_id:string} */
    public function createOrder(float $amount, string $currency, string $returnUrl, string $cancelUrl): array;

    /** return array{capture_id:string,status:string,raw:array} */
    public function capturePayment(string $orderToken): array;

    /** return array{refund_id:string,status:string,raw:array} */
    public function refund(string $captureId, ?float $amount = null, string $currency = 'USD'): array;
}
