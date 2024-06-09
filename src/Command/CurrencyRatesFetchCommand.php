<?php

namespace App\Command;

use App\Service\CurrencyRateFetcher;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'currency:fetch',
    description: 'Fetch currency rates'
)]
class CurrencyRatesFetchCommand extends Command
{
    public function __construct(private CurrencyRateFetcher $currencyRatesFetcher)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $result = $this->currencyRatesFetcher->updateCurrencyRate();
            if ($result) {
                $io->success('Currency rates have been successfully fetched');
            } else {
                $io->warning('Currency rates have already been updated today');
            }
        } catch (\Exception $e) {
            $io->error('An error occurred: ' . $e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
