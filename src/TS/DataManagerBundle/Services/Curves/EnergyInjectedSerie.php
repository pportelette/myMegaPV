<?php

namespace TS\DataManagerBundle\Services\Curves;

class EnergyInjectedSerie extends Serie
{

    public function __construct()
  {
    $this->setType('column');
    $this->setColor('#4572A7');
    $this->setUnit('kWh');
    $this->setStacking('normal');
  }
}
