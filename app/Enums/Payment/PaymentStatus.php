<?php

namespace App\Enums\Payment;

enum PaymentStatus: string {
    case PENDING   = 'pending';
    case APPROVED  = 'approved';
    case COMPLETED = 'completed';
    case FAILED    = 'failed';
    case REFUNDED  = 'refunded';
}
