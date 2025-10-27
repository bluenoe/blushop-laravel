<?php

namespace App\Support;

class Money
{
    public static function formatVnd(int $vnd): string {
        return number_format($vnd, 0, ',', '.') . '₫';
    }
}
