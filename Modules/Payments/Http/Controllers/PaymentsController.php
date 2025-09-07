<?php
namespace Modules\Payments\Http\Controllers;

use Inertia\Inertia;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\PaymentRequest;
use App\Http\Controllers\Controller;
use Modules\Payments\Services\Gateway\GatewayFactory;

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
    $approval = $gateway->createOrder(
        $request->amount,
        'USD',
        route('handleReturn'),
        route('handleCancel')
    );

    PaymentRequest::create([
        'member_id' => auth()->id(),
        'gateway' => $request->payment_method,
        'amount' => $request->amount,
        'status' => 'pending',
        'request_payload' => json_encode(['amount' => $request->amount]),
    ]);

    return response()->json($approval);
}


    // public function handleReturn(Request $request)
    // {
    //     $gateway = GatewayFactory::make($request->payment_method);
    //     $capture = $gateway->capturePayment($request->token);

    //     $payment = Transaction::where('member_id', auth()->id())
    //         ->where('status', 'pending')
    //         ->latest()
    //         ->first();

    //     $payment->update([
    //         'status' => $capture['status'] === 'COMPLETED' ? 'completed' : 'failed',
    //         'response_payload' => json_encode($capture),
    //     ]);

    //     return redirect()->route('dashboard')->with('success', 'Payment completed.');
    // }

    public function refund(PaymentRequest $payment, Request $request)
    {
        $gateway = GatewayFactory::make($payment->gateway);

        $refund = $gateway->refundPayment($payment->id, $payment->amount, $request->reason ?? '');

        $payment->update([
            'status' => 'refunded',
            'response_payload' => json_encode($refund),
        ]);

        return back()->with('success', 'Payment refunded successfully.');
    }
}
