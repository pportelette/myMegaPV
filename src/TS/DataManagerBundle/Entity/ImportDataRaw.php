<?php

namespace TS\DataManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImportDataRaw
 *
 * @ORM\Table(name="import_data_raw")
 * @ORM\Entity(repositoryClass="TS\DataManagerBundle\Repository\ImportDataRawRepository")
 */
class ImportDataRaw
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
     * @ORM\ManyToOne(targetEntity="TS\AssetsBundle\Entity\Site", inversedBy="importDataRaws")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var float
     *
     * @ORM\Column(name="energyInjected", type="float")
     */
    private $energyInjected;

    /**
     * @var string
     *
     * @ORM\Column(name="irradiation", type="float")
     */
    private $irradiation;

    public function __construct(){
        $this->date = new \DateTime(); 
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
     * @return ImportDataRaw
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
     * Set energyInjected.
     *
     * @param float $energyInjected
     *
     * @return ImportDataRaw
     */
    public function setEnergyInjected($energyInjected)
    {
        $this->energyInjected = $energyInjected;

        return $this;
    }

    /**
     * Get energyInjected.
     *
     * @return float
     */
    public function getEnergyInjected()
    {
        return $this->energyInjected;
    }

    /**
     * Set irradiation.
     *
     * @param float $irradiation
     *
     * @return ImportDataRaw
     */
    public function setIrradiation($irradiation)
    {
        $this->irradiation = $irradiation;

        return $this;
    }

    /**
     * Get irradiation.
     *
     * @return float
     */
    public function getIrradiation()
    {
        return $this->irradiation;
    }

    /**
     * Set site.
     *
     * @param \TS\AssetsBundle\Entity\Site $site
     *
     * @return ImportDataRaw
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
