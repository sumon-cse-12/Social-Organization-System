<?php
namespace Modules\Payments\Services\Transactions;

use App\Models\MonthlyFee;
use Modules\Payments\Services\Gateway\PaymentGatewayInterface;
use Modules\Payments\Services\Transactions\TransactionTypeInterface;

class FeePaymentTransaction implements TransactionTypeInterface
{
    public function process(array $data, PaymentGatewayInterface $gateway): array
    {

       $monthlyFee = MonthlyFee::create([
            'member_id' => auth('member')->user()->id,          // Member who is paying
            'amount'    => $data['amount'],             // Amount paid
            'for_month' => $data['for_month'] ?? now()->startOfMonth()->toDateString(),
            'gateway'   => $data['payment_method'],            // Payment method
            'currency'  => $data['currency'] ?? 'USD', // Default USD
            'status'    => 'pending',                   // Initial status
            'notes'     => $data['notes'] ?? null,
        ]);

        return $gateway->createOrder(
            $data['amount'],
            $data['currency'] ?? 'USD',
            $data['returnUrl'] ?? '',
            $data['cancelUrl'] ?? ''
        );
    }
}
