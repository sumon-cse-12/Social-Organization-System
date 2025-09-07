<?php

namespace Modules\Payments\Services\Gateway;

use InvalidArgumentException;
use App\Models\PaymentSetting;
use Modules\Payments\Services\Gateway\Gateway;
use Modules\Payments\Services\Gateway\PayPalGateway;
use Modules\Payments\Services\Gateway\StripeGateway;
use Modules\Payments\Services\Gateway\OfflineGateway;
use Modules\Payments\Services\Gateway\PaymentGatewayInterface;

class GatewayFactory
{
    public static function make(string $method): PaymentGatewayInterface
    {
        $method = strtolower($method);

        $setting = PaymentSetting::where('gateway', $method)
            ->where('is_active', true)
            ->first();

        if (!$setting) {
            throw new InvalidArgumentException("Gateway [$method] not configured or inactive.");
        }

        $credentials = is_array($setting->value)
            ? $setting->value
            : json_decode($setting->value ?? '[]', true);

        return match ($method) {
            'paypal' => app(PayPalGateway::class)->setCredentials($credentials),
            'stripe' => app(StripeGateway::class)->setCredentials($credentials),
            'offline' => app(OfflineGateway::class)->setCredentials($credentials),
            default => throw new InvalidArgumentException("Gateway [$method] not supported."),
        };
    }
}
