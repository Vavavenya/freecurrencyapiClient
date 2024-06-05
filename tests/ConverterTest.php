<?php

namespace App\Tests;

use App\Enum\CurrencyEnum;
use App\Service\Converter;
use App\Service\Http\FreeCurrencyGuzzleClient;
use PHPUnit\Framework\TestCase;

class ConverterTest extends TestCase
{
    public function testGetJsonCurrencyPrice()
    {
        $testJsonResponse = [
            "data" => [
                "EUR" => 0.5
            ]
        ];

        $freeCurrencyClientMock = $this->createMock(FreeCurrencyGuzzleClient::class);

        $freeCurrencyClientMock->expects($this->once())
            ->method('getJsonPairPrice')
            ->willReturn(json_encode($testJsonResponse));

        $converter = new Converter($freeCurrencyClientMock);

        $result = $converter->convert(100,CurrencyEnum::USD->value,CurrencyEnum::EUR->value);

        $this->assertEquals(50, $result);
    }
}
