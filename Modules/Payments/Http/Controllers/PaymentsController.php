<?php
namespace Modules\Payments\Http\Controllers;

use Inertia\Inertia;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentRequest;
use App\Enums\Payment\PaymentStatus;
use App\Http\Controllers\Controller;
use Modules\Payments\Services\Gateway\GatewayFactory;
use Modules\Payments\Services\Transactions\TransactionTypeFactory;
class PaymentsController extends Controller
{
    public function index()
    {
        $member = auth('member')->user();
        if (!$member) return redirect()->route('member.login');

        return Inertia::render('Member/CheckOut');
    }

    public function pay(Request $request)
{

    $request->validate([
        'payment_method' => 'required|string',
        'amount' => 'required|numeric|min:1',
    ]);

    $gateway = GatewayFactory::make($request->payment_method);

    $transactionHandler = TransactionTypeFactory::make($request->type);
    $data = $transactionHandler->process($request->all(), $gateway);
    $transaction = \App\Models\Transaction::create([
        'member_id'    => auth('member')->id(),
        'type'         => $request->type,
        'gateway'      => $request->payment_method,
        'amount'       => $request->amount,
        'status'       => 'pending',
        'meta'         => $data['notes'] ?? null,
        'approval_url' => $data['approval_url'] ?? null,
    ]);

    // return response()->json($transaction);
    return redirect()->back()->with('success', 'Transaction completed successfully.');

}


    public function refund(PaymentStatus $payment, Request $request)
    {
        // $gateway = GatewayFactory::make($payment->gateway);

        // $refund = $gateway->refundPayment($payment->id, $payment->amount, $request->reason ?? '');

        // $payment->update([
        //     'status' => 'refunded',
        //     'response_payload' => json_encode($refund),
        // ]);

        // return back()->with('success', 'Payment refunded successfully.');
    }
}
