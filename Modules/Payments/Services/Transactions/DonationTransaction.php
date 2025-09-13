<?php
namespace Modules\Payments\Services\Transactions;

use Modules\Payments\Services\Gateway\PaymentGatewayInterface;
use Modules\Payments\Services\Transactions\TransactionTypeInterface;

class DonationTransaction implements TransactionTypeInterface
{
    public function process(array $data, PaymentGatewayInterface $gateway): array
    {
        // Example: payment for membership fee
        return $gateway->createOrder(
            $data['amount'],
            $data['currency'] ?? 'USD',
            $data['returnUrl'] ?? '',
            $data['cancelUrl'] ?? ''
        );
    }
}
