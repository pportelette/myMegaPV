<?php

namespace TS\DataManagerBundle\Curves;

use Zend\Json\Expr;
use Ob\HighchartsBundle\Highcharts\Highchart;

class TrendCurves
{
    private $data;
    private $xData;
    private $site;
    
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
            
            $series [] = array(
                'name'  => $name,
                'type'  => $type,
                'color' => $color,
                'data'  => $data,
                'yAxis' => $i
            );
            $i++;
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
                'opposite' => $opposite
            );
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