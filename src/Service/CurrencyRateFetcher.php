<?php

namespace App\Service;

use App\Entity\Currency;
use App\Entity\CurrencyRate;
use App\Enum\CurrencyEnum;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Repository\CurrencyRepository;

class CurrencyRateFetcher
{
    private EntityRepository $currencyRateRepository;
    private array $allCurrency;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Converter              $converter,
        private CurrencyRepository     $currencyRepository
    )
    {
        $this->currencyRateRepository = $this->entityManager->getRepository(CurrencyRate::class);
        $this->allCurrency = $this->currencyRepository->findAll();
    }

    public function updateCurrencyRate(): bool
    {
        $currentDateTime = new \DateTime();
        if ($this->isUpdateNeeded($currentDateTime)) {
            foreach (CurrencyEnum::getEnumValues() as $fromCurrency) {
                $currenciesRate = $this->converter->getCurrenciesRate($fromCurrency);
                foreach ($currenciesRate as $toCurrency => $rate) {
                    $currencyRate = new CurrencyRate();
                    $currencyRate->setFromCurrency($this->getCurrencyIdByName($fromCurrency));
                    $currencyRate->setToCurrency($this->getCurrencyIdByName($toCurrency));
                    $currencyRate->setRate($rate);
                    $currencyRate->setDate($currentDateTime);
                    $this->entityManager->persist($currencyRate);
                }
            }
            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    private function isUpdateNeeded(DateTime $currentDateTime): bool
    {
        $lastRecord = $this->currencyRateRepository->findLastRecord()?->getDate()->format('Y-m-d');

        return $lastRecord === null || $lastRecord !== $currentDateTime->format('Y-m-d');
    }

    private function getCurrencyIdByName(string $name): Currency
    {
        foreach ($this->allCurrency as $currency) {
            if ($currency->getName() === $name) {
                return $currency;
            }
        }

        throw new \InvalidArgumentException("Currency with name [$name] not found");
    }
}
