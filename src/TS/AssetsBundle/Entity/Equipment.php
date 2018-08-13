<?php

namespace TS\AssetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="TS\AssetsBundle\Repository\EquipmentRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"equipment" = "Equipment", "inverter" = "Inverter"})
 */
class Equipment
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
     * @ORM\ManyToOne(targetEntity="TS\AssetsBundle\Entity\Substation", inversedBy="equipments")
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
     * @return Equipment
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
     * @return Equipment
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
     * Set substation.
     *
     * @param \TS\AssetsBundle\Entity\Substation $substation
     *
     * @return Equipment
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

    public function __toString() {
        return $this->getName();
    }
}