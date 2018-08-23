<?php

namespace TS\DataManagerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImportDataRow
 *
 * @ORM\Table(name="import_data_row")
 * @ORM\Entity(repositoryClass="TS\DataManagerBundle\Repository\ImportDataRowRepository")
 */
class ImportDataRow
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
     * @ORM\ManyToOne(targetEntity="TS\AssetsBundle\Entity\Site", inversedBy="importDataRows")
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

    /**
     * @var string
     *
     * @ORM\Column(name="ens", type="float")
     */
    private $ens;

    public function __construct(){
        $this->date = new \DateTime(); 
        $this->ens = 0; 
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
     * @return ImportDataRow
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
     * @return ImportDataRow
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
     * @return ImportDataRow
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
     * @return ImportDataRow
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
     * Set ens.
     *
     * @param float $ens
     *
     * @return ImportDataRow
     */
    public function setEns($ens)
    {
        $this->ens = $ens;

        return $this;
    }

    /**
     * Get ens.
     *
     * @return float
     */
    public function getEns()
    {
        return $this->ens;
    }
}
