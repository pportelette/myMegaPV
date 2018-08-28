<?php

namespace TS\DataManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;
use TS\AssetsBundle\Entity\Site;
use TS\DataManagerBundle\Curves\EnergyInjectedSerie;
use TS\DataManagerBundle\Curves\IrradiationSerie;
use TS\DataManagerBundle\Curves\ENSSerie;
use TS\DataManagerBundle\Curves\PRSerie;
use Ob\HighchartsBundle\Highcharts\Highchart;

class CurvesController extends Controller
{
    public function curvesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $search = new search();
        $ob = new Highchart();
        
        $formSearch = $this->get('form.factory')->create(SearchType::class, $search);
        $energyPeriod = 0;
        $irradiationPeriod = 1;
        $PRPeriod = 0;
        $ensPeriod = 0;
        $availabilityPeriod = 0;
        
        if ($request->isMethod('POST') && $formSearch->handleRequest($request)->isValid()) {
            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TSDataManagerBundle:ImportDataRow')
            ;
            $site = $search->getSite();
            $session->set('search', $search);
            $rows = $repository->getSelectedData($search->getStartDate(), $search->getEndDate(), $site);
            $session->set('rows', $rows);
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
                $availabilityPeriod = $energyPeriod * 100 / ($energyPeriod + $ensPeriod);
                $PRPeriod = ($energyPeriod + $ensPeriod) * 100000 / ($irradiationPeriod * $powerPeak);
                $pr[] = ($energyRow + $ensRow) * 100000 / ($irradiationRow * $powerPeak);
            }
            $session->set('dates', $dates);

            $serie4 = new ENSSerie();
            $serie4->setSerie($ens);
            $serie4->setName('ENS');
            $serie4->setOpposite(false);
            $session->set('serie4', $serie4);
            $series[]=$serie4;
            
            $serie1 = new EnergyInjectedSerie();
            $serie1->setSerie($energies);
            $serie1->setName('Energy Injected');
            $serie1->setOpposite(false);
            $session->set('serie1', $serie1);
            $series[]=$serie1;
            
            $serie2 = new IrradiationSerie();
            $serie2->setSerie($irradiations);
            $serie2->setName('Irradiation');
            $serie2->setOpposite(true);
            $session->set('serie2', $serie2);
            $series[]=$serie2;

            $serie3 = new PRSerie();
            $serie3->setSerie($pr);
            $serie3->setName('PR');
            $serie3->setOpposite(true);
            $session->set('serie3', $serie3);
            $series[]=$serie3;

            $curvesService = $this->container->get('ts_data_manager.curves');
            $ob = $curvesService->trendCurve($series, $dates, $site);

            return $this->render('@TSDataManager/DataManager/curves.html.twig', array(
                'chart'=>$ob,
                'energyPeriod'=>$energyPeriod,
                'irradiationPeriod'=>$irradiationPeriod,
                'PRPeriod'=>$PRPeriod,
                'ensPeriod'=>$ensPeriod,
                'availabilityPeriod'=>$availabilityPeriod,
                'formSearch'=>$formSearch->createview()
            ));
        }
        
        return $this->render('@TSDataManager/DataManager/curves.html.twig', array(
            'chart'=>$ob,
            'energyPeriod'=>$energyPeriod,
            'irradiationPeriod'=>$irradiationPeriod,
            'PRPeriod'=>$PRPeriod,
            'ensPeriod'=>$ensPeriod,
            'availabilityPeriod'=>$availabilityPeriod,
            'formSearch'=>$formSearch->createview()
        ));
    }

    public function trendAction(Request $request, $e = 1, $i = 1, $p = 1) {
        $session = $request->getSession();
        $site = $session->get('search')->getSite();
        $dates = $session->get('dates');

        $series=[];
        if ($e == 1) {
            $series[]=$session->get('serie1');
        }
        if ($i == 1) {
            $series[]=$session->get('serie2');
        }
        if ($p == 1) {
            $series[]=$session->get('serie2');
        }

        $curvesService = $this->container->get('ts_data_manager.curves');
        $ob = $curvesService->trendCurve($series, $dates, $site);
        
        return $this->render('@TSDataManager/DataManager/curveDiv.html.twig', array(
            'chart'=>$ob
        ));
    }
}
