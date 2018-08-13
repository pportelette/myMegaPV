<?php

namespace TS\DataManagerBundle\Curves;

class IrradiationSerie extends Serie
{

    public function __construct()
  {
    $this->setType('spline');
    $this->setColor('#AAAA00');
    $this->setUnit('Wh/m²');
  }
}
