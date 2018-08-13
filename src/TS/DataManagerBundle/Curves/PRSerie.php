<?php

namespace TS\DataManagerBundle\Curves;

class PRSerie extends Serie
{

    public function __construct()
  {
    $this->setType('spline');
    $this->setColor('#AA0000');
    $this->setUnit('%');
  }
}
