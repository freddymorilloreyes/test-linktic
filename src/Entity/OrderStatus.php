<?php

namespace App\Entity;

enum OrderStatus: string
{
    case Pending = 'P';
    case Active = 'A';
    case Suspended = 'S';
    case Canceled = 'C';

    public function label(): string
    {
        return match($this) {
            OrderStatus::Pending => 'Pending',
            OrderStatus::Active => 'Active',
            OrderStatus::Suspended => 'Suspended',
            OrderStatus::Canceled => 'Canceled',
        };
    }
}