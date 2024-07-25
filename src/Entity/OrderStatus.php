<?php

namespace App\Entity;

enum OrderStatus: string
{
    case Requested = 'Requested';
    case InProcess = 'InProcess';
    case Rejected = 'Rejected';
    case Completed = 'Completed';

    public function label(): string
    {
        return match ($this) {
            OrderStatus::Requested => 'Requested',
            OrderStatus::InProcess => 'In Process',
            OrderStatus::Rejected => 'Rejected',
            OrderStatus::Completed => 'Completed',
        };
    }

    public function isRequested(): bool
    {
        return $this == OrderStatus::Requested;
    }

    public function isInProcess(): bool
    {
        return $this == OrderStatus::InProcess;
    }

    public function isRejected(): bool
    {
        return $this == OrderStatus::InProcess;
    }

    public function isCompleted(): bool
    {
        return $this == OrderStatus::InProcess;
    }
}