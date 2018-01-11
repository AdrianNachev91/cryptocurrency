<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateCurrency extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('crypt:calculate-currency')
            ->setDescription('Gets information about cryptocurrencies and decides whether to buy or sell any');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currencyCalculator = $this->getContainer()->get('app.currency_calculator');
        $currencyCalculator->cleanAndSaveCurrencies();
        $currencyCalculator->sellAndBuy();
    }
}