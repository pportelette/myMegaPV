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
     * @ORM\ManyToOne(targetEntity="TS\AssetsBundle\Entity\Client", inversedBy="sites")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="TS\DataManagerBundle\Entity\ImportDataRow", mappedBy="site")
     */
    private $importDataRows;

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
     * Add importDataRow.
     *
     * @param \TS\DataManagerBundle\Entity\ImportDataRow $importDataRow
     *
     * @return Site
     */
    public function addImportDataRow(\TS\DataManagerBundle\Entity\ImportDataRow $importDataRow)
    {
        $this->importDataRows[] = $importDataRow;

        $importDataRow->setSite($this);

        return $this;
    }

    /**
     * Remove importDataRow.
     *
     * @param \TS\DataManagerBundle\Entity\ImportDataRow $importDataRow
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeImportDataRow(\TS\DataManagerBundle\Entity\ImportDataRow $importDataRow)
    {
        return $this->importDataRows->removeElement($importDataRow);
    }

    /**
     * Get importDataRows.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImportDataRows()
    {
        return $this->importDataRows;
    }

    public function __toString() {
        return $this->getSiteName();
    }

    /**
     * Set client.
     *
     * @param \TS\AssetsBundle\Entity\Client $client
     *
     * @return Site
     */
    public function setClient(\TS\AssetsBundle\Entity\Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client.
     *
     * @return \TS\AssetsBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
