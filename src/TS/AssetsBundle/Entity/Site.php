<?php

namespace TS\AssetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Site
 *
 * @ORM\Table(name="site")
 * @ORM\Entity(repositoryClass="TS\AssetsBundle\Repository\SiteRepository")
 */
class Site
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
}
