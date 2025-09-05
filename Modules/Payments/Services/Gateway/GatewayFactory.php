<?php
namespace Modules\Payments\Services\Gateway;

use InvalidArgumentException;
use App\Models\PaymentSetting;

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

        $value = is_array($setting->value) ? $setting->value : json_decode($setting->value ?? '[]', true);

        $credentials = match ($method) {
            'paypal' => [
                'mode'      => $setting->mode,
                'apiKey'    => $value['apiKey'] ?? $value['client_id'] ?? null,
                'apiSecret' => $value['apiSecret'] ?? $value['client_secret'] ?? null,
            ],
            default => throw new InvalidArgumentException("Gateway [$method] not supported."),
        };

        $gateway = match ($method) {
            'paypal' => app(PayPalGateway::class),
        };

        return $gateway->setCredentials($credentials);
    }
}
