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
     * @ORM\ManyToOne(targetEntity="TS\AssetsBundle\Entity\Site", cascade={"persist"})
     * @ORM\JoinColumn(nullable= false)
     */
    private $site;

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
     * @ORM\ManyToOne(targetEntity="TS\AssetsBundle\Entity\Substation", cascade={"persist"})
     * @ORM\JoinColumn(nullable= false)
     */
    private $substation;

    /**
     * @ORM\ManyToOne(targetEntity="TS\AssetsBundle\Entity\Equipment", cascade={"persist"})
     * @ORM\JoinColumn(nullable= false)
     */
    private $equipment;

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
      $this->ensOperator = 0;
      $this->ensOther = 0;
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
     * @param \TS\AssetsBundle\Entity\Substation $substation
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
     * @return \TS\AssetsBundle\Entity\Substation
     */
    public function getSubstation()
    {
        return $this->substation;
    }

    /**
     * Set equipment
     *
     * @param \TS\AssetsBundle\Entity\Equipment $equipment
     *
     * @return Event
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return \TS\AssetsBundle\Entity\Equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
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

    /**
     * Set site.
     *
     * @param \TS\AssetsBundle\Entity\Site $site
     *
     * @return Event
     */
    public function setSite(\TS\AssetsBundle\Entity\Site $site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site.
     *
     * @return \TS\AssetsBundle\Entity\Site
     */
    public function getSite()
    {
        return $this->site;
    }
}
