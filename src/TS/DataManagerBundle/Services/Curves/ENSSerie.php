<?php

namespace TS\DataManagerBundle\Services\Curves;

class ENSSerie extends Serie
{

    public function __construct()
  {
    $this->setType('column');
    $this->setColor('#DA4646');
    $this->setUnit('kWh');
    $this->setStacking('normal');
  }
}
