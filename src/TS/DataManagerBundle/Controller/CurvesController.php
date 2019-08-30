<?php

namespace TS\DataManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;

class CurvesController extends Controller
{
    public function curvesAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $curvesService = $this->container->get('ts_data_manager.curves');
        
        $search = new Search();
        $formSearch = $this->get('form.factory')->create(SearchType::class, $search);
                
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

            $result = $curvesService->trend($site, $rows, 1, 1, 1);

            return $this->render('@TSDataManager/DataManager/curves.html.twig', array(
                'result'=>$result,
                'formSearch'=>$formSearch->createview()
            ));
        }
        
        $searche = $session->get('search');
        
        if ($searche) {
            $site = $searche->getSite();
			$startDate = $searche->getStartDate();
            $endDate = $searche->getEndDate();
            
            $search->setStartDate($startDate);
            $search->setEndDate($endDate);

            $formSearch = $this->get('form.factory')->create(SearchType::class, $search);
            $rows = $session->get('rows');
            
            $result = $curvesService->trend($site, $rows);
        } else {
            $result = null;
        }
        
        return $this->render('@TSDataManager/DataManager/curves.html.twig', array(
            'result'=>$result,
            'formSearch'=>$formSearch->createview()
        ));
    }

}
