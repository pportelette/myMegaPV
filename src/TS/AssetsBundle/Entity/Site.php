<?php

namespace TS\AssetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Site
 *
 * @ORM\Table(name="site")
 * @ORM\Entity(repositoryClass="TS\AssetsBundle\Repository\SiteRepository")
 */
class Site
{
    /**
     * @ORM\OneToMany(targetEntity="TS\AssetsBundle\Entity\Substation", mappedBy="site")
     */
    private $substations;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="TS\DataManagerBundle\Entity\ImportDataRaw", mappedBy="site")
     */
    private $importDataRaws;

    /**
     * @var string
     *
     * @ORM\Column(name="siteName", type="string", length=30)
     */
    private $siteName;

    /**
     * @var string
     *
     * @ORM\Column(name="powerPeak", type="decimal", precision=10, scale=2)
     */
    private $powerPeak;

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
     * Set siteName.
     *
     * @param string $siteName
     *
     * @return Site
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;

        return $this;
    }

    /**
     * Get siteName.
     *
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * Set powerPeak.
     *
     * @param string $powerPeak
     *
     * @return Site
     */
    public function setPowerPeak($powerPeak)
    {
        $this->powerPeak = $powerPeak;

        return $this;
    }

    /**
     * Get powerPeak.
     *
     * @return string
     */
    public function getPowerPeak()
    {
        return $this->powerPeak;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->substations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add substation.
     *
     * @param \TS\AssetsBundle\Entity\Substation $substation
     *
     * @return Site
     */
    public function addSubstation(\TS\AssetsBundle\Entity\Substation $substation)
    {
        $this->substations[] = $substation;

        $substation->setSite($this);

        return $this;
    }

    /**
     * Remove substation.
     *
     * @param \TS\AssetsBundle\Entity\Substation $substation
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSubstation(\TS\AssetsBundle\Entity\Substation $substation)
    {
        return $this->substations->removeElement($substation);
    }

    /**
     * Get substations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubstations()
    {
        return $this->substations;
    }

    /**
     * Add importDataRaw.
     *
     * @param \TS\DataManagerBundle\Entity\ImportDataRaw $importDataRaw
     *
     * @return Site
     */
    public function addImportDataRaw(\TS\DataManagerBundle\Entity\ImportDataRaw $importDataRaw)
    {
        $this->importDataRaws[] = $importDataRaw;

        $importDataRaw->setSite($this);

        return $this;
    }

    /**
     * Remove importDataRaw.
     *
     * @param \TS\DataManagerBundle\Entity\ImportDataRaw $importDataRaw
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeImportDataRaw(\TS\DataManagerBundle\Entity\ImportDataRaw $importDataRaw)
    {
        return $this->importDataRaws->removeElement($importDataRaw);
    }

    /**
     * Get importDataRaws.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImportDataRaws()
    {
        return $this->importDataRaws;
    }
}
