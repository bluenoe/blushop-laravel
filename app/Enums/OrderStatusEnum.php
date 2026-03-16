<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case SHIPPED = 'shipped';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';

    public function next(): ?self
    {
        return match($this) {
            self::PENDING => self::PROCESSING,
            self::PROCESSING => self::SHIPPED,
            self::SHIPPED => self::COMPLETED,
            default => null,
        };
    }

    public function isTerminal(): bool
    {
        return in_array($this, [self::COMPLETED, self::CANCELLED, self::REFUNDED]);
    }

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::PROCESSING => 'Processing',
            self::SHIPPED => 'Shipped',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
            self::REFUNDED => 'Refunded',
        };
    }

    public function actionLabel(): string
    {
        return match($this) {
            self::PENDING => 'Mark as Processing',
            self::PROCESSING => 'Mark as Shipped',
            self::SHIPPED => 'Mark as Completed',
            default => 'Unknown Action',
        };
    }
}
