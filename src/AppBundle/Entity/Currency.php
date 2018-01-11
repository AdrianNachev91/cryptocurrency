<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity()
* @ORM\Table(name="currency")
*/
class Currency
{
    /**
    * @var int
    * @ORM\Id
    * @ORM\GeneratedValue
    * @ORM\Column(type="integer")
    */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", name="name", nullable=false)
     */
    private $name;

    /**
     * @var double
     *
     * @ORM\Column(type="decimal", name="amount", nullable=false)
     */
    private $amount;

    /**
     * @var Rate[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Rate", mappedBy="currency")
     */
    private $rates;

    /**
     * Currency constructor.
     */
    public function __construct()
    {
        $this->rates = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Currency
     */
    public function setId(int $id): Currency
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Currency
     */
    public function setName(string $name): Currency
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Currency
     */
    public function setAmount(float $amount): Currency
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return Rate[]|ArrayCollection
     */
    public function getRates()
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): Currency
    {
        $this->rates->add($rate);
        return $this;
    }

    public function removeRate(Rate $rate)
    {
        $this->rates->removeElement($rate);
    }
}