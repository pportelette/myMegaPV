<?php

namespace TS\ReportsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use TS\ReportsBundle\Entity\Report;
use TS\ReportsBundle\Form\ReportType;
use TS\AssetsBundle\Entity\Site;
use TS\RegisterBundle\Entity\Event;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;

class ReportsController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $site = new Site();

        $report = new Report();
        $formReport = $this->get('form.factory')->create(ReportType::class, $report);
        
        $listEvents=[];
        $rows=[];
        $ob = new Highchart();
        $result['chart'] = $ob;
        if($request->isMethod('POST')) {
			if ($request->request->has('appbundle_search') && $formReport->handleRequest($request)->isValid()) {
                $startDate = $report->getStartDate();
                $endDate = $report->getEndDate();
                $site = $report->getSite();
                
                $curvesService = $this->container->get('ts_data_manager.curves');
                $rowRepository = $this->getDoctrine()->getManager()->getRepository('TSDataManagerBundle:ImportDataRow');
                $rows = $rowRepository->getSelectedData($startDate, $endDate, $site);
                
                if ($report->getRegister()){
                $eventRepository = $this->getDoctrine()->getManager()->getRepository('TSRegisterBundle:Event');
                $listEvents = $eventRepository->getSelectedEvents($startDate, $endDate, $site);
                $report->setRegister($listEvents);
                }
                
                if ($report->getRows()){

                $report->setRows($rows);
                }
                
                if ($report->getCurve()){
                $result = $curvesService->trend($site, $rows);
                $report->setCurve($result);
                }

                $footer = $this->renderView('@TSReports/Reports/footer.html.twig');

                $html = $this->renderView('@TSReports/Reports/printPdf.html.twig', array(
                    'report' => $report,
                    'site'=>$site,
				));
        
                $this->get('knp_snappy.pdf')->generateFromHtml(
                    $html, 
                    "C:/wamp64/www/project/web/snappy/file.pdf", 
                    array(
                        'disable-javascript' => false,
                        'javascript-delay' => 3000,
                        'footer-html' =>$footer,
                    ),
                    true
                );

				return $this->render('@TSReports/Reports/index.html.twig', array(
                    'listEvents' => $listEvents,
                    'site'=>$site,
                    'result'=>$result,
                    'tab'=>$rows,
					'formReport' => $formReport -> createView()
				));
            }
        }

        return $this->render('@TSReports/Reports/index.html.twig', array(
            'listEvents' => $listEvents,
            'chart'=>$ob,
            'result'=>$result,
            'tab'=>$rows,
            'formReport' => $formReport->createview()
        ));
    }
}
