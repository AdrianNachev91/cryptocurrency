<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Currency;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user
            ->setFirstName('Adrian')
            ->setLastName('Nachev')
            ->setBalance(500);
        $manager->persist($user);

        $currencies = [
            'btceur',
            'xrpeur',
            'ltceur',
            'etheur',
            'bcheur'
        ];

        foreach ($currencies as $currency) {
            $c = new Currency();
            $c
                ->setName($currency)
                ->setAmount(0)
            ;
            $manager->persist($c);
        }

        $manager->flush();
    }
}