<?php
namespace Modules\Payments\Services;

use Exception;
use Illuminate\Support\Facades\DB;

use Modules\Payments\Services\Gateway\GatewayFactory;

class CheckoutService
{
    public function start(string $method, int $memberId, float $amount, string $currency, string $successUrl, string $cancelUrl): string
    {
        return DB::transaction(function () use ($method, $memberId, $amount, $currency, $successUrl, $cancelUrl) {

            $payment = Payment::create([
                'member_id' => $memberId,
                'gateway'   => $method,
                'currency'  => $currency,
                'amount'    => $amount,
                'status'    => 'pending',
            ]);

            $gateway = GatewayFactory::make($method);

            $order = $gateway->createOrder($amount, $currency, $successUrl, $cancelUrl);

            $payment->update([
                'order_id'     => $order['order_id'],
                'approval_url' => $order['approval_url'],
                'status'       => 'approved', // approved = waiting_user_approval
            ]);

            return $order['approval_url'];
        });
    }

    public function capture(string $method, string $orderToken): Payment
    {
        return DB::transaction(function () use ($method, $orderToken) {
            $payment = Payment::where('gateway', $method)
                ->where('order_id', $orderToken)
                ->lockForUpdate()
                ->firstOrFail();

            $gateway = GatewayFactory::make($method);
            $res = $gateway->capturePayment($orderToken);

            $payment->update([
                'capture_id' => $res['capture_id'] ?? null,
                'status'     => in_array(($res['status'] ?? ''), ['COMPLETED','APPROVED','CAPTURED']) ? 'captured' : strtolower($res['status'] ?? 'failed'),
                'paid_at'    => now(),
                'meta'       => array_merge($payment->meta ?? [], ['capture' => $res['raw']]),
            ]);

            return $payment;
        });
    }

    public function cancel(string $method, string $orderToken): void
    {
        Payment::where('gateway', $method)
            ->where('order_id', $orderToken)
            ->update(['status' => 'canceled']);
    }
}
