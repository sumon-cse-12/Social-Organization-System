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
       
        $value = is_string($item->value) ? json_decode($item->value) : (object) $item->value;

        return [
            'mode' => $item->mode,
            'isActive' => $item->is_active,
            'apiKey' => $item->gateway !== 'offline' ? ($value->apiKey ?? '') : '',
            'apiSecret' => $item->gateway !== 'offline' ? ($value->apiSecret ?? '') : '',
            'offlineNote' => $item->gateway === 'offline' ? ($value->offlineNote ?? '') : ''
        ];
    });

    return Inertia::render('Admin/Settings/Payment', [
        'settings' => $settings
    ]);
}


       public function store(Request $request)
    {
        $gateway = $request->input('gateway');
        $mode = $request->input('mode', 'sandbox');
        $isActive = $request->input('isActive', false);

        $value = [];

        if ($gateway === 'offline') {
            $value = ['offlineNote' => $request->input('offlineNote')];
        } else {
            $value = [
                'apiKey' => $request->input('apiKey'),
                'apiSecret' => $request->input('apiSecret')
            ];
        }

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
