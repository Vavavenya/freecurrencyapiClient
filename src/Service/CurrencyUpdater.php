<?php

namespace App\Service;

use App\Entity\Currency;
use App\Enum\CurrencyEnum;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CurrencyUpdater
{
    private EntityRepository $currencyRepository;

    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->currencyRepository = $this->entityManager->getRepository(Currency::class);
    }

    public function updateCurrency() : void
    {
        if ($this->isUpdateNeeded()) {
            foreach (CurrencyEnum::getEnumValues() as $currencyCode => $currencyName) {
                $currencyRate = new Currency();
                $currencyRate->setName($currencyName);
                $currencyRate->setCode($currencyCode);
                $this->entityManager->persist($currencyRate);
            }
            $this->entityManager->flush();
        }
    }

    private function isUpdateNeeded(): bool
    {
        return count(CurrencyEnum::getEnumValues()) > $this->currencyRepository->getTotalCount();
    }
}
