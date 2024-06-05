<?php

namespace App\Controller;

use App\Form\Type\ConverterType;
use App\Repository\CurrencyRateRepository;
use App\Service\Converter;
use App\Service\CurrencyRateFetcher;
use App\Service\CurrencyUpdater;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrenciesController extends AbstractController
{
    /**
     * @required
     */
    public function __construct(
        private Converter $converter,
        private CurrencyRateFetcher $currencyFetcher,
        private CurrencyUpdater $currencyUpdater,
        private CurrencyRateRepository $currencyRateRepository
)
    {
    }

    #[Route(path: '/convert', name: 'convert')]
    public function convert(Request $request): Response
    {
        $form = $this->createForm(ConverterType::class);

        $form->handleRequest($request);


        $result = null;
        if ($form->isSubmitted()) {
            $formData = $form->getData();
            $amount = $formData['amount'];
            $fromCurrency = $formData['fromCurrency'];
            $toCurrency = $formData['toCurrency'];


            $convertedAmount = $this->converter->convert($amount, $fromCurrency, $toCurrency);

            $result = sprintf('%d %s → %f %s', $amount, $fromCurrency, $convertedAmount, $toCurrency);
        }


        return $this->render('converter.html.twig', [
            'form' => $form->createView(),
            'result' => $result
        ]);
    }

    #[Route(path: '/currencies', name: 'currencies_list', methods: ['GET'])]
    public function list(): Response
    {
        $this->currencyUpdater->updateCurrency();
        $this->currencyFetcher->updateCurrencyRate();

        return $this->render('exchange_rates.html.twig', [
            'currencies' => $this->currencyRateRepository->findAll(),
        ]);
    }
}
