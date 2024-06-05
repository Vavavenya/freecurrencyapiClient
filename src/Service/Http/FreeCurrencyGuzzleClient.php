<?php

namespace App\Service\Http;

use App\Enum\CurrencyEnum;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class FreeCurrencyGuzzleClient implements HttpClientInterface
{
    private Client $client;

    private string $apikey;

    public function __construct(string $apikey)
    {
        $this->client = new Client();
        $this->apikey = $apikey;
    }

    public function getJsonCurrencyPrice(string $currency): string
    {
        $otherCurrency = CurrencyEnum::getEnumValues();
        unset($otherCurrency[$currency]);
        $otherCurrency = array_values($otherCurrency);
        $urlPartCurrencies = implode('%2C', $otherCurrency);

        $url = sprintf(
            'https://api.freecurrencyapi.com/v1/latest?apikey=%s&currencies=%s&base_currency=%s',
            $this->apikey,
            $urlPartCurrencies,
            $currency
        );

        return $this->get($url);
    }

    public function getJsonPairPrice(string $fromCurrency, string $toCurrency): string
    {
        $url = sprintf(
            'https://api.freecurrencyapi.com/v1/latest?apikey=%s&currencies=%s&base_currency=%s',
            $this->apikey,
            $toCurrency,
            $fromCurrency
        );

        return $this->get($url);
    }

    public function get(string $url, array $options = []): string
    {
        $request = new Request('GET', $url);
        try {
            $response = $this->client->send($request);

            if ($response->getStatusCode() !== 200) {
                throw new RequestException('Request failed with status code ' . $response->getStatusCode(), $request);
            }
        } catch (GuzzleException $e) {
            throw new RequestException('Error ' . $e->getMessage(), $request);
        }

        return $response->getBody();
    }
}
