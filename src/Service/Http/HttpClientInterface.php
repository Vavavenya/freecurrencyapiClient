<?php

namespace App\Service\Http;

interface HttpClientInterface
{
    public function get(string $url, array $options = []): string;

    public function getJsonPairPrice(string $fromCurrency, string $toCurrency): string;
    public function getJsonCurrencyPrice(string $currency): string;
}
