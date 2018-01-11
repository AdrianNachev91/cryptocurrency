<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity(repositoryClass="AppBundle\Repository\RateRepository")
* @ORM\Table(name="rate")
*/
class Rate
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @var Currency
    * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Currency", inversedBy="rates")
    */
    private $currency;

    /**
     * @var string
     * @ORM\Column(type="decimal", name="rate", nullable=false)
     */
    private $rate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", name="date", nullable=false)
     */
    private $date;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Rate
     */
    public function setId(int $id): Rate
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     * @return Rate
     */
    public function setCurrency(Currency $currency): Rate
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return string
     */
    public function getRate(): string
    {
        return $this->rate;
    }

    /**
     * @param string $rate
     * @return Rate
     */
    public function setRate(string $rate): Rate
    {
        $this->rate = $rate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Rate
     */
    public function setDate(\DateTime $date): Rate
    {
        $this->date = $date;
        return $this;
    }
}