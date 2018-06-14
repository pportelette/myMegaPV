<?php

namespace TS\AssetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inverter
 *
 * @ORM\Table(name="inverter")
 * @ORM\Entity(repositoryClass="TS\AssetsBundle\Repository\InverterRepository")
 */
class Inverter
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
     * @ORM\ManyToOne(targetEntity="TS\AssetsBundle\Entity\Substation", inversedBy="inverters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $substation;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=30)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="power", type="integer")
     */
    private $power;


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
     * @return Inverter
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
     * Set brand.
     *
     * @param string $brand
     *
     * @return Inverter
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand.
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Inverter
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set power.
     *
     * @param int $power
     *
     * @return Inverter
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power.
     *
     * @return int
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set substation.
     *
     * @param \TS\AssetsBundle\Entity\Substation $substation
     *
     * @return Inverter
     */
    public function setSubstation(\TS\AssetsBundle\Entity\Substation $substation)
    {
        $this->substation = $substation;

        return $this;
    }

    /**
     * Get substation.
     *
     * @return \TS\AssetsBundle\Entity\Substation
     */
    public function getSubstation()
    {
        return $this->substation;
    }
}
