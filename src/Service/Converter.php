<?php

namespace App\Service;

use App\Service\Http\HttpClientInterface;

class Converter
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    public function convert(int $amount, string $fromCurrency, string $toCurrency): float
    {
        $exchangeRate = $this->getExchangeRate($fromCurrency, $toCurrency);

        return $amount * $exchangeRate;
    }


    public function getExchangeRate(string $fromCurrency, string $toCurrency): float
    {
        $json = $this->client->getJsonPairPrice($fromCurrency, $toCurrency);
        $arrayData = json_decode($json, true);

        return $arrayData['data'][$toCurrency];
    }

    public function getCurrenciesRate(string $currency): array
    {
        $json = $this->client->getJsonCurrencyPrice($currency);
        $arrayData = json_decode($json, true);

        $arrayData = $arrayData['data'];
        $currencyRates = [];

        foreach ($arrayData as $currency => $rate) {
            $currencyRates[$currency] = $rate;
        }

        return $currencyRates;
    }
}
