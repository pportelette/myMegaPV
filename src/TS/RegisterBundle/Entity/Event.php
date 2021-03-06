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
     * @ORM\Column(name="ens", type="float", nullable=true)
     */
    private $ens;

    /**
     * @ORM\OneToMany(targetEntity="TS\RegisterBundle\Entity\Ens", mappedBy="event", cascade={"remove", "persist"})
     */
    private $losses;

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
      $this->ens = 0;
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

    public function addEns($ens)
    {
        $this->ens += $ens;

        return $this;
    }
    /**
     * Set ens
     *
     * @param float $ens
     *
     * @return Event
     */
    public function setEns($ens)
    {
        $this->ens = $ens;

        return $this;
    }

    /**
     * Get ens
     *
     * @return float
     */
    public function getEns()
    {
        return $this->ens;
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

    /**
     * Add loss.
     *
     * @param \TS\RegisterBundle\Entity\Ens $loss
     *
     * @return Event
     */
    public function addLoss(\TS\RegisterBundle\Entity\Ens $loss)
    {
        $this->losses[] = $loss;

        $loss->setEvent($this);

        return $this;
    }

    /**
     * Remove loss.
     *
     * @param \TS\RegisterBundle\Entity\Ens $loss
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLoss(\TS\RegisterBundle\Entity\Ens $loss)
    {
        return $this->losses->removeElement($loss);
    }

    /**
     * Get losses.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLosses()
    {
        return $this->losses;
    }
}
