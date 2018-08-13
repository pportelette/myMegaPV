<?php

namespace TS\AssetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inverter
 *
 * @ORM\Table(name="inverter")
 * @ORM\Entity(repositoryClass="TS\AssetsBundle\Repository\InverterRepository")
 */
class Inverter extends Equipment
{
    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=30)
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="power", type="integer")
     */
    private $power;

    /**
     * Set model.
     *
     * @param string $model
     *
     * @return Inverter
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
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
}
