<?php

namespace App\Payment\Domain\Enum;

enum PaymentProvider: string
{
    case ACI = 'aci';
    case SHIFT4 = 'shift4';

    public static function getAll(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function getRequirements(): string
    {
        return implode('|', self::getAll());
    }
}
