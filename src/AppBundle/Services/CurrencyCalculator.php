<?php

namespace AppBundle\Services;

use AppBundle\Entity\Rate;
use AppBundle\Util\LiteBitAPI;
use Doctrine\ORM\EntityManager;

class CurrencyCalculator
{
    /** @var LiteBitAPI */
    private $litebitAPI;
    /** @var EntityManager */
    private $entityManager;

    /**
     * CurrencyCalculator constructor.
     * @param LiteBitAPI $litebitAPI
     * @param EntityManager $entityManager
     */
    public function __construct(LiteBitAPI $litebitAPI, EntityManager $entityManager)
    {
        $this->litebitAPI = $litebitAPI;
        $this->entityManager = $entityManager;
    }

    public function cleanAndSaveCurrencies() {
        $currencyRepository = $this->entityManager->getRepository('AppBundle:Currency');
        $currencies = $currencyRepository->findAll();

        try {
            foreach ($currencies as $currency) {
                $endpoint = 'ticker_hour/' . $currency->getName();
                $this->litebitAPI->setEndpoint($endpoint);
                $data = $this->litebitAPI->getCurrencyData();
                $rate = new Rate();
                $rate
                    ->setCurrency($currency)
                    ->setRate($data['last'])
                    ->setDate(new \DateTime());
                $this->entityManager->persist($rate);
            }

            $this->entityManager->flush();

            $rateRepository = $this->entityManager->getRepository('AppBundle:Rate');
            $rates = $rateRepository->findAllOlderThanTwoDays();
            foreach ($rates as $rate) {
                $this->entityManager->remove($rate);
            }
            $this->entityManager->flush();

        } catch (\Exception $e) {
            // Handle the exception
        }
    }

    public function sellAndBuy() {
        $currencyRepository = $this->entityManager->getRepository('AppBundle:Currency');
        $currencies = $currencyRepository->findAll();

        $user = $this->entityManager->getRepository('AppBundle:User')->findAll();

        try {
            foreach ($currencies as $currency) {
                if ($currency->getRates()->count() >= 2) {
                    $rates = $currency->getRates();
                    $day1Price = $rates[0]->getRate();
                    $day2Price = $rates[1]->getRate();
                    if (($day2Price - $day1Price >= $day1Price) || ($day2Price - $day1Price < 0)) {
                        if ($currency->getAmount() > 0) {
                            $sellFor = $currency->getAmount() * $day2Price;
                            $user[0]->setBalance($user[0] + $sellFor);
                            $currency->setAmount(0);
                        }
                    } elseif ($day2Price - $day1Price > 0) {
                        if ($user[0]->getBalance() >= $day2Price) {
                            $currency->setAmount($currency->getAmount() + 1);
                            $user[0]->setBalance($user[0]->getBalance() - $day2Price);
                        }
                    }
                }
            }

            $this->entityManager->flush();
        } catch (\Exception $e) {
            // handle exception
        }
    }
}