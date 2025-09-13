<?php
// Modules/Payments/Services/Transaction/TransactionTypeInterface.php
namespace Modules\Payments\Services\Transactions;

use Modules\Payments\Services\Gateway\PaymentGatewayInterface;

interface TransactionTypeInterface
{
    public function process(array $data, PaymentGatewayInterface $gateway): array;
}
