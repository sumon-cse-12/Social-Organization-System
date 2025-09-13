<?php
namespace Modules\Payments\Services\Transactions;
use InvalidArgumentException;
use Modules\Payments\Services\Transactions\DonationTransaction;
use Modules\Payments\Services\Transactions\EventFeeTransaction;
use Modules\Payments\Services\Transactions\FeePaymentTransaction;
// use Modules/Payments/Services/Transaction/TransactionTypeInterface.php
use Modules\Payments\Services\Transactions\TransactionTypeInterface;
class TransactionTypeFactory
{
    public static function make(string $type): TransactionTypeInterface
    {
        return match (strtolower($type)) {
            'monthly_fee'        => app(FeePaymentTransaction::class),
            'donation_fee'   => app(DonationTransaction::class),
            'event_fee' => app(EventFeeTransaction::class),
            default      => throw new InvalidArgumentException("Transaction type [$type] not supported."),
        };
    }
}
