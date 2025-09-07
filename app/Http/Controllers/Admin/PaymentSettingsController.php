<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use App\Http\Controllers\Controller;

class PaymentSettingsController extends Controller
{
    public function index()
    {
        $settings = PaymentSetting::all()->keyBy('gateway')->map(function ($item) {
            $value = is_string($item->value) ? json_decode($item->value, true) : (array) $item->value;

            return [
                'mode' => $item->mode,
                'isActive' => $item->is_active,
                'apiKey' => $value['apiKey'] ?? '',
                'apiSecret' => $value['apiSecret'] ?? '',
                'offlineNote' => $value['offlineNote'] ?? '',
            ];
        });

        return Inertia::render('Admin/Settings/Payment', [
            'settings' => $settings
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'gateway' => 'required|string',
            'apiKey' => 'nullable|string',
            'apiSecret' => 'nullable|string',
            'mode' => 'nullable|string',
            'offlineNote' => 'nullable|string',
            'isActive' => 'nullable|boolean',
        ]);

        $gateway = $request->input('gateway');
        $mode = $request->input('mode', 'sandbox');
        $isActive = $request->input('isActive', false);

        // Map generic input to gateway-specific keys
        $value = match($gateway) {
            'paypal' => [
                'client_id' => $request->input('apiKey'),
                'client_secret' => $request->input('apiSecret'),
                'mode' => $mode,
            ],
            'stripe' => [
                'publishable_key' => $request->input('apiKey'),
                'secret_key' => $request->input('apiSecret'),
                'mode' => $mode,
            ],
            'razorpay' => [
                'key_id' => $request->input('apiKey'),
                'key_secret' => $request->input('apiSecret'),
                'mode' => $mode,
            ],
            'offline' => [
                'offlineNote' => $request->input('offlineNote') ?? 'Please follow offline instructions',
            ],
            default => [
                'apiKey' => $request->input('apiKey'),
                'apiSecret' => $request->input('apiSecret'),
                'mode' => $mode,
            ]
        };

        PaymentSetting::updateOrCreate(
            ['gateway' => $gateway],
            [
                'mode' => $mode,
                'is_active' => $isActive,
                'value' => $value
            ]
        );

        return redirect()->back()->with('success', 'Payment settings updated successfully.');
    }
}
