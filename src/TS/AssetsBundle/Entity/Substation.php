<?php

namespace TS\AssetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Substation
 *
 * @ORM\Table(name="substation")
 * @ORM\Entity(repositoryClass="TS\AssetsBundle\Repository\SubstationRepository")
 */
class Substation
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="TS\AssetsBundle\Entity\Site", inversedBy="substations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity="TS\AssetsBundle\Entity\Inverter", mappedBy="substation")
     */
    private $inverters;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Substation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set site.
     *
     * @param \TS\AssetsBundle\Entity\Site $site
     *
     * @return Substation
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
     * Constructor
     */
    public function __construct()
    {
        $this->inverters = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add inverter.
     *
     * @param \TS\AssetsBundle\Entity\Inverter $inverter
     *
     * @return Substation
     */
    public function addInverter(\TS\AssetsBundle\Entity\Inverter $inverter)
    {
        $this->inverters[] = $inverter;

        $inverter->setSubstation($this);

        return $this;
    }

    /**
     * Remove inverter.
     *
     * @param \TS\AssetsBundle\Entity\Inverter $inverter
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeInverter(\TS\AssetsBundle\Entity\Inverter $inverter)
    {
        return $this->inverters->removeElement($inverter);
    }

    /**
     * Get inverters.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInverters()
    {
        return $this->inverters;
    }
}
