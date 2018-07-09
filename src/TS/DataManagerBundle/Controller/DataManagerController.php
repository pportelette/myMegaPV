<?php

namespace TS\DataManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TS\DataManagerBundle\Form\UploadFileType;
use TS\DataManagerBundle\Entity\File;
use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;
use TS\DataManagerBundle\Entity\ImportDataRaw;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Zend\Json\Expr;

class DataManagerController extends Controller
{
    public function DataManagerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $listSites = $em->getRepository('TSAssetsBundle:Site')->findAll();
        $site = $listSites[0];

        $search = new search();
        $formSearch = $this->get('form.factory')->create(SearchType::class, $search);
        if ($request->isMethod('POST') && $formSearch->handleRequest($request)->isValid()) {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TSDataManagerBundle:ImportDataRaw')
            ;
            $rows = $repository->getSelectedData($search->getStartDate(), $search->getEndDate());
            return $this->render('@TSDataManager/DataManager/index.html.twig', array(
                'tab'=>$rows,
                'site'=>$site,
                'listSites'=>$listSites,
                'formSearch'=>$formSearch->createview()
            ));
        }
        $rows = $em->getRepository('TSDataManagerBundle:ImportDataRaw')->findAll();
        return $this->render('@TSDataManager/DataManager/index.html.twig', array(
            'tab'=>$rows,
            'site'=>$site,
            'listSites'=>$listSites,
            'formSearch'=>$formSearch->createview()
        ));
    }

    public function ImportAction(Request $request)
    {
        $tab = 'vide';
        $file = new file();
        $form = $this->get('form.factory')->create(UploadFileType::class, $file);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $file->upload();
            $path = "../var/cache/dev/".$file->getName();

            $importService = $this->container->get('ts_data_manager.import');
            $tableau = $importService->importData($path);

            return $this->render('@TSDataManager/DataManager/import.html.twig', array(
                'form'=>$form->createview(),
                'tab'=>$tableau
            ));
        }
        return $this->render('@TSDataManager/DataManager/import.html.twig', array(
            'form'=>$form->createview(),
            'tab'=>$tab
        ));
    }

    public function saveAction(Request $request)
    {
        $tab= $request->getContent();
        $table = json_decode($tab);
        $em = $this->getDoctrine()->getManager();
        //ligne provisoire
        $site = $em->getRepository('TSAssetsBundle:Site')->find(1);
        
        foreach ($table as $raw) {
            $dataRaw = new importDataRaw();
            foreach ($raw as $key => $cell){
                switch ($key){
                    case 'date':
                        $format = str_replace("/", "-", $cell);
                        $days = strtotime($format);
                        $date = date('Y-m-d', $days);
                        $dateO = \DateTime::createFromFormat('Y-m-d', $date);
                        $dataRaw->setDate($dateO);
                    break;
                    case 'energy':
                        $dataRaw->setEnergyInjected($cell+0);
                    break;
                    case 'irradiation':
                        $dataRaw->setIrradiation($cell+0);
                    break;
                    default :
                }
            }
            $dataRaw->setSite($site);
            $em->persist($dataRaw);
        }
        //$em->flush();

        return $this->render('@TSDataManager/DataManager/test.html.twig', array(
            'table'=>$table
        ));
    }

    public function curvesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $listSites = $em->getRepository('TSAssetsBundle:Site')->findAll();
        $site = $listSites[0];
        $search = new search();
        $formSearch = $this->get('form.factory')->create(SearchType::class, $search);
        if ($request->isMethod('POST') && $formSearch->handleRequest($request)->isValid()) {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TSDataManagerBundle:ImportDataRaw')
            ;
            $rows = $repository->getSelectedData($search->getStartDate(), $search->getEndDate());
            foreach ($rows as $row) {
                $dates[]=$row->getDate()->format('d/m/Y');
                $energies[]=$row->getEnergyInjected();
                $irradiations[]=$row->getIrradiation()*277.77;
                $pr[] = $row->getEnergyInjected() * 100000 / ($row->getIrradiation()*277.77 * $site->getPowerPeak());
            }
            $series = array(
                array(
                    'name'  => 'Energy Injected',
                    'type'  => 'column',
                    'color' => '#4572A7',
                    'data'  => $energies,
                ),
                array(
                    'name'  => 'Irradiation',
                    'type'  => 'spline',
                    'color' => '#AAAA00',
                    'yAxis' => 1,
                    'data'  => $irradiations,
                ),
                array(
                    'name'  => 'PR',
                    'type'  => 'spline',
                    'color' => '#AA4643',
                    'yAxis' => 2,
                    'data'  => $pr,
                ),
            );
            $yData = array(
                array(
                    'labels' => array(
                        'formatter' => new Expr('function () { return this.value + " " }'),
                        'style'     => array('color' => '#4572A7')
                    ),
                    'gridLineWidth' => 0,
                    'title' => array(
                        'text'  => 'Energy Injected',
                        'style' => array('color' => '#4572A7')
                    ),
                ),
                array(
                    'labels' => array(
                        'formatter' => new Expr('function () { return this.value + " " }'),
                        'style'     => array('color' => '#AAAA13')
                    ),
                    'title' => array(
                        'text'  => 'Irradiation',
                        'style' => array('color' => '#AAAA13')
                    ),
                    'opposite' => true,
                ),
                array(
                    'labels' => array(
                        'formatter' => new Expr('function () { return this.value + " " }'),
                        'style'     => array('color' => '#AA4643')
                    ),
                    'title' => array(
                        'text'  => 'PR',
                        'style' => array('color' => '#AA4643')
                    ),
                    'opposite' => true,
                ),
            );
            $categories = $dates;
            
            $ob = new Highchart();
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
                             return this.x + ": <b>" + this.y + "</b> " + unit;
                         }');
            $ob->tooltip->formatter($formatter);
            $ob->series($series);
            return $this->render('@TSDataManager/DataManager/curves.html.twig', array(
                'chart'=>$ob,
                'listSites' => $listSites,
                'formSearch'=>$formSearch->createview()
            ));
        }
        
        $rows = $em->getRepository('TSDataManagerBundle:ImportDataRaw')->findAll();
        foreach ($rows as $row) {
            $dates[]=$row->getDate()->format('d/m/Y');
            $energies[]=$row->getEnergyInjected();
            $irradiations[]=$row->getIrradiation()*277.77;
            $pr[] = $row->getEnergyInjected() * 100000 / ($row->getIrradiation()*277.77 * $site->getPowerPeak());
        }
        $series = array(
            array(
                'name'  => 'Energy Injected',
                'type'  => 'column',
                'color' => '#4572A7',
                'data'  => $energies,
            ),
            array(
                'name'  => 'Irradiation',
                'type'  => 'spline',
                'color' => '#AAAA00',
                'yAxis' => 1,
                'data'  => $irradiations,
            ),
            array(
                'name'  => 'PR',
                'type'  => 'spline',
                'color' => '#AA4643',
                'yAxis' => 2,
                'data'  => $pr,
            ),
        );
        $yData = array(
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + " " }'),
                    'style'     => array('color' => '#4572A7')
                ),
                'gridLineWidth' => 0,
                'title' => array(
                    'text'  => 'Energy Injected',
                    'style' => array('color' => '#4572A7')
                ),
            ),
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + " " }'),
                    'style'     => array('color' => '#AAAA13')
                ),
                'title' => array(
                    'text'  => 'Irradiation',
                    'style' => array('color' => '#AAAA13')
                ),
                'opposite' => true,
            ),
            array(
                'labels' => array(
                    'formatter' => new Expr('function () { return this.value + " " }'),
                    'style'     => array('color' => '#AA4643')
                ),
                'title' => array(
                    'text'  => 'PR',
                    'style' => array('color' => '#AA4643')
                ),
                'opposite' => true,
            ),
        );
        $categories = $dates;
        
        $ob = new Highchart();
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
                         return this.x + ": <b>" + this.y + "</b> " + unit;
                     }');
        $ob->tooltip->formatter($formatter);
        $ob->series($series);
        
        return $this->render('@TSDataManager/DataManager/curves.html.twig', array(
            'chart'=>$ob,
            'listSites' => $listSites,
            'formSearch'=>$formSearch->createview()
        ));
    }
}
