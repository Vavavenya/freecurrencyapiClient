<?php

namespace App\Enum;

enum  CurrencyEnum: string
{
    case  USD = 'USD';
    case  EUR = 'EUR';
    case  PLN = 'PLN';

    public static function getEnumValues(): array
    {
        return [
            self::USD->name => self::USD->value,
            self::EUR->name => self::EUR->value,
            self::PLN->name => self::PLN->value,
        ];
    }
}
