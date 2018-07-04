<?php

namespace TS\RegisterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="TS\RegisterBundle\Repository\EventRepository")
 */
class Event
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
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="site_name", type="string", length=40, nullable=true)
     */
    private $siteName;

    /**
     * @var string
     *
     * @ORM\Column(name="origin", type="string", length=255, nullable=true)
     */
    private $origin;

    /**
     * @var string
     *
     * @ORM\Column(name="consequence", type="string", length=255, nullable=true)
     */
    private $consequence;

    /**
     * @var string
     *
     * @ORM\Column(name="substation", type="string", length=20, nullable=true)
     */
    private $substation;

    /**
     * @var string
     *
     * @ORM\Column(name="equipement", type="string", length=255, nullable=true)
     */
    private $equipement;

    /**
     * @var float
     *
     * @ORM\Column(name="ens_operator", type="float", nullable=true)
     */
    private $ensOperator;

    /**
     * @var float
     *
     * @ORM\Column(name="ens_other", type="float", nullable=true)
     */
    private $ensOther;

    /**
     * @var text
     *
     * @ORM\Column(name="coment", type="text", nullable=true)
     */
    private $coment;

    public function __construct()
    {
      $this->startDate = new \Datetime();
      $this->endDate = new \Datetime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Event
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Event
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set siteName
     *
     * @param string $siteName
     *
     * @return Event
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;

        return $this;
    }

    /**
     * Get siteName
     *
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * Set origin
     *
     * @param string $origin
     *
     * @return Event
     */
    public function setOrigin($origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * Get origin
     *
     * @return string
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Set substation
     *
     * @param string $substation
     *
     * @return Event
     */
    public function setSubstation($substation)
    {
        $this->substation = $substation;

        return $this;
    }

    /**
     * Get substation
     *
     * @return string
     */
    public function getSubstation()
    {
        return $this->substation;
    }

    /**
     * Set equipement
     *
     * @param string $equipement
     *
     * @return Event
     */
    public function setEquipement($equipement)
    {
        $this->equipement = $equipement;

        return $this;
    }

    /**
     * Get equipement
     *
     * @return string
     */
    public function getEquipement()
    {
        return $this->equipement;
    }

    /**
     * Set ensOperator
     *
     * @param float $ensOperator
     *
     * @return Event
     */
    public function setEnsOperator($ensOperator)
    {
        $this->ensOperator = $ensOperator;

        return $this;
    }

    /**
     * Get ensOperator
     *
     * @return float
     */
    public function getEnsOperator()
    {
        return $this->ensOperator;
    }

    /**
     * Set ensOther
     *
     * @param float $ensOther
     *
     * @return Event
     */
    public function setEnsOther($ensOther)
    {
        $this->ensOther = $ensOther;

        return $this;
    }

    /**
     * Get ensOther
     *
     * @return float
     */
    public function getEnsOther()
    {
        return $this->ensOther;
    }

    /**
     * Set coment
     *
     * @param string $coment
     *
     * @return Event
     */
    public function setComent($coment)
    {
        $this->coment = $coment;

        return $this;
    }

    /**
     * Get coment
     *
     * @return string
     */
    public function getComent()
    {
        return $this->coment;
    }

    /**
     * Set consequence
     *
     * @param string $consequence
     *
     * @return Event
     */
    public function setConsequence($consequence)
    {
        $this->consequence = $consequence;

        return $this;
    }

    /**
     * Get consequence
     *
     * @return string
     */
    public function getConsequence()
    {
        return $this->consequence;
    }
}
