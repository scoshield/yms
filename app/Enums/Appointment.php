<?php

namespace App\Enums;

enum Appointment: string
{
    case STATUS_PENDING = 'pending';
    case STATUS_DISABLED = 'disabled';
    case STATUS_ACTIVE = 'active';
    case STATUS_EXPIRED = 'expired';

    case TYPE_SUBSCRIPTION = 'subscription';
    case TYPE_OTHER = 'other';
}
