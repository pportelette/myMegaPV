<?php

namespace TS\RegisterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ens
 *
 * @ORM\Table(name="ens")
 * @ORM\Entity(repositoryClass="TS\RegisterBundle\Repository\EnsRepository")
 */
class Ens
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="TS\RegisterBundle\Entity\Event", inversedBy="losses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="ensOperator", type="float", nullable=true)
     */
    private $ensOperator;

    /**
     * @var float|null
     *
     * @ORM\Column(name="ensOther", type="float", nullable=true)
     */
    private $ensOther;

    public function __construct()
    {
      $this->ensOperator = 0;
      $this->ensOther = 0;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Ens
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set ensOperator.
     *
     * @param float $ensOperator
     *
     * @return Ens
     */
    public function setEnsOperator($ensOperator)
    {
        $this->ensOperator = $ensOperator;

        return $this;
    }

    /**
     * Get ensOperator.
     *
     * @return float
     */
    public function getEnsOperator()
    {
        return $this->ensOperator;
    }

    /**
     * Set ensOther.
     *
     * @param float|null $ensOther
     *
     * @return Ens
     */
    public function setEnsOther($ensOther = null)
    {
        $this->ensOther = $ensOther;

        return $this;
    }

    /**
     * Get ensOther.
     *
     * @return float|null
     */
    public function getEnsOther()
    {
        return $this->ensOther;
    }

    /**
     * Set event.
     *
     * @param \TS\RegisterBundle\Entity\Event $event
     *
     * @return Ens
     */
    public function setEvent(\TS\RegisterBundle\Entity\Event $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event.
     *
     * @return \TS\RegisterBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }
}
