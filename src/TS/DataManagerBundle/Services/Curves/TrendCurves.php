<?php

namespace TS\DataManagerBundle\Services\Curves;

use Zend\Json\Expr;
use Ob\HighchartsBundle\Highcharts\Highchart;

class TrendCurves
{
    private $data;
    private $xData;
    private $site;
    
    public function trend($site, $rows, $e = 1, $i = 1, $p = 1) {        
        $energyPeriod = 0;
        $irradiationPeriod = 1;
        $PRPeriod = 0;
        $ensPeriod = 0;
        $availabilityPeriod = 0;
        foreach ($rows as $row) {
            $energyRow = $row->getEnergyInjected();
            $irradiationRow=$row->getIrradiation();
            $powerPeak = $site->getPowerPeak();
            $ensRow = $row->getEns();
            $ens[] = $ensRow;
            $ensPeriod += $ensRow;
            $dates[]=$row->getDate()->format('d/m/Y');
            $energyPeriod += $energyRow;
            $energies[]=$energyRow;
            $irradiationPeriod += $irradiationRow;
            $irradiations[]=$irradiationRow;
            $pr[] = ($energyRow + $ensRow) * 100000 / ($irradiationRow * $powerPeak);
        }
        
        $availabilityPeriod = $energyPeriod * 100 / ($energyPeriod + $ensPeriod);
        $PRPeriod = ($energyPeriod + $ensPeriod) * 100000 / ($irradiationPeriod * $powerPeak);

        $serie4 = new ENSSerie();
        $serie4->setSerie($ens);
        $serie4->setName('ENS');
        $serie4->setOpposite(false);
        $series[]=$serie4;
        
        $serie1 = new EnergyInjectedSerie();
        $serie1->setSerie($energies);
        $serie1->setName('Energy Injected');
        $serie1->setOpposite(false);
        $series[]=$serie1;
        
        $serie2 = new IrradiationSerie();
        $serie2->setSerie($irradiations);
        $serie2->setName('Irradiation');
        $serie2->setOpposite(true);
        $series[]=$serie2;

        $serie3 = new PRSerie();
        $serie3->setSerie($pr);
        $serie3->setName('PR');
        $serie3->setOpposite(true);
        $series[]=$serie3;

        $series=[];
        if ($e == 1) {
            $series[]=$serie4;
            $series[]=$serie1;
        }
        if ($i == 1) {
            $series[]=$serie2;
        }
        if ($p == 1) {
            $series[]=$serie3;
        }

        $ob = $this->trendCurve($series, $dates, $site);
        
        return array(
            'chart'=>$ob, 
            'energyPeriod'=>$energyPeriod, 
            'irradiationPeriod'=>$irradiationPeriod, 
            'PRPeriod'=>$PRPeriod, 
            'ensPeriod'=>$ensPeriod, 
            'availabilityPeriod'=>$availabilityPeriod
        );
    }
    
    public function trendCurve($data, $xData, $site)
    {
        $ob = new Highchart();
        $i = 0;
        forEach($data as $serie) {
            $data = $serie->getSerie();
            $name = $serie->getName();
            $type = $serie->getType();
            $color = $serie->getColor();
            $opposite = $serie->getOpposite();
            $stacking = $serie->getStacking();
            
            if ($name != 'ENS') {
                $series [] = array(
                    'name'  => $name,
                    'type'  => $type,
                    'color' => $color,
                    'data'  => $data,
                    'yAxis' => $i,
                    'stacking' => $stacking
                );
                $yData[] = array(
                    'labels' => array(
                        'formatter' => new Expr('function () { return this.value + " " }'),
                        'style'     => array('color' => $color)
                    ),
                    'gridLineWidth' => 0,
                    'title' => array(
                        'text'  => $name,
                        'style' => array('color' => $color)
                    ),
                    'opposite' => $opposite,
                    'min' => 0
                );
            } else {
                $series [] = array(
                    'name'  => $name,
                    'type'  => $type,
                    'color' => $color,
                    'data'  => $data,
                    'yAxis' => $i+1,
                    'stacking' => $stacking
                );
                $yData[] = array(
                    'labels' => array(
                        'formatter' => new Expr('function () { return this.value + " " }'),
                        'style'     => array('color' => $color)
                    ),
                    'gridLineWidth' => 0,
                    'title' => array(
                        'text'  => '',
                        'style' => array('color' => $color)
                    ),
                    'opposite' => $opposite
                );
            }
            
            $i++;

        }
        $categories = $xData;
        
        $ob->chart->renderTo('linechart'); // The #id of the div where to render the chart
        $ob->chart->type('column');
        $ob->title->text($site->getSiteName());
        $ob->xAxis->categories($categories);
        $ob->yAxis($yData);
        $ob->legend->enabled(false);
        $formatter = new Expr('function () {
                         var unit = {
                             "Energy Injected": "kWh",
                             "ENS": "kWh",
                             "Irradiation": "Wh/m²",
                             "PR": "%"
                         }[this.series.name];
                         return this.x + ": <b>" + this.y.toFixed(2) + "</b> " + unit;
                     }');
        $ob->tooltip->formatter($formatter);
        $ob->series($series);

        return $ob;
    }
}