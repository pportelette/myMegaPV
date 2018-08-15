<?php

namespace TS\DataManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;
use TS\AssetsBundle\Entity\Site;
use TS\DataManagerBundle\Entity\ImportDataRow;
use TS\DataManagerBundle\Form\ImportDataRowEditType;

class DataManagerController extends Controller
{
    public function DataManagerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session=$request->getSession();
        
        $search  = new Search();

        $formSearch = $this->get('form.factory')->create(SearchType::class, $search);
        if ($request->isMethod('POST') && $formSearch->handleRequest($request)->isValid()) {
            $session->set('search', $search);

            $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('TSDataManagerBundle:ImportDataRow')
            ;
            $startDate = $search->getStartDate();
            $endDate = $search->getEndDate();

            $rows = $repository->getSelectedData($search->getStartDate(), $search->getEndDate());
            $session->set('rows', $rows);
            $site = $search->getSite();
            return $this->render('@TSDataManager/DataManager/index.html.twig', array(
                'tab'=>$rows,
                'site'=>$site,
                'formSearch'=>$formSearch->createview()
            ));
        }
        $search = $session->get('search');
        $site = $search->getSite();
        $rows=$session->get('rows');

        return $this->render('@TSDataManager/DataManager/index.html.twig', array(
            'tab'=>$rows,
            'site'=>$site,
            'formSearch'=>$formSearch->createview()
        ));
    }

    public function editRowAction (Request $request, $id) {
		$rowEdited = new ImportDataRow();
		$em = $this->getDoctrine()->getManager();
		$rowEdited = $em->getRepository('TSDataManagerBundle:ImportDataRow')->find($id);
		$formEditRow = $this->createForm(ImportDataRowEditType::class, $rowEdited, array(
			'action' => $this->generateUrl('ts_data_manager_editrow', array(
                'id'=>$id,
                'Request'=>$request)
            )
        ));
		
		if($request->isMethod('POST') && $formEditRow->handleRequest($request)->isValid()) {
			$em->flush();
			return $this->redirectToRoute('ts_data_manager_homepage');
		}

		return $this->render('@TSDataManager/DataManager/formEditRow.html.twig', array(
			'row' => $rowEdited,
			'formEditRow' => $formEditRow -> createView()
		));
	}

	public function removeRowAction (Request $request, $id) {
		$row = new ImportDataRow();
		$em = $this->getDoctrine()->getManager();
		$row = $em->getRepository('TSDataManagerBundle:ImportDataRow')->find($id);
		
		$em->remove($row);
		$em->flush();

		return $this->redirectToRoute('ts_dat_manager_homepage');
	}
}
