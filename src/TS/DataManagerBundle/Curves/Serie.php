<?php

namespace TS\DataManagerBundle\Curves;

class Serie
{
    private $serie;
    private $name;
    private $type;
    private $color;
    private $unit;
    private $opposite;

    public function setSerie($serie)
    {
        $this->serie = $serie;

        return $this;
    }

    public function getSerie()
    {
        return $this->serie;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function setOpposite($opposite)
    {
        $this->opposite = $opposite;

        return $this;
    }

    public function getOpposite()
    {
        return $this->opposite;
    }
}
