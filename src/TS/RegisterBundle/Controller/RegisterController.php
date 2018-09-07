<?php

namespace TS\RegisterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TS\RegisterBundle\Entity\Event;
use TS\RegisterBundle\Entity\Ens;
use TS\AssetsBundle\Entity\Site;
use TS\RegisterBundle\Form\EventType;
use TS\RegisterBundle\Form\EventEditType;
use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;

class RegisterController extends Controller{
    
	public function registerAction(Request $request){
		
		$em = $this->getDoctrine()->getManager();
		$session = $request->getSession();
		$listSites = $em->getRepository('TSAssetsBundle:Site')->findAll();

		$search = new search();
		$formSearch = $this->get('form.factory')->create(SearchType::class, $search);
		
		$event = new Event();
		$formNewEvent = $this->createForm(EventType::class, $event);

		if($request->isMethod('POST')) {
			if ($request->request->has('appbundle_search') && $formSearch->handleRequest($request)->isValid()) {
				$session->set('search', $search);
				$repository = $em->getRepository('TSRegisterBundle:Event');
				
				$site = $search->getSite();
				$startDate = $search->getStartDate();
				$endDate = $search->getEndDate();
				
				$listEvents = $repository->getSelectedEvents($startDate, $endDate, $site);
				$session->set('listEvents', $listEvents);
				
				return $this->render('@TSRegister/Register/register.html.twig', array(
					'listSites' => $listSites, 
					'listEvents' => $listEvents,
					'formSearch' => $formSearch -> createView(),
					'formNewEvent' => $formNewEvent -> createView()
				));
			}
			if ($request->request->has('ts_registerbundle_event') && $formNewEvent->handleRequest($request)->isValid()) {
				if ($event->getEns() != 0) {
					$startDate = clone $event->getStartDate();
					$startDate->setTime(0, 0);
					$endDate = clone $event->getEndDate();
					$endDate->setTime(0, 0);
					do {
						$ens = new ens();
						$date = clone $startDate;
						$ens->setEvent($event);
						$ens->setDate($date);
						$event->addLoss($ens);
						$startDate->add(new \DateInterval('P1D'));
					} while ($startDate <= $endDate);
				}
				$em->persist($event);
				$em->flush();

				return $this->redirectToRoute('ts_register_homepage');
			}

		}

		$listEvents = $em->getRepository('TSRegisterBundle:Event')->findAll();
		$session->set('listEvents', $listEvents);

		return $this->render('@TSRegister/Register/register.html.twig', array(
			'listSites' => $listSites, 
			'listEvents' => $listEvents,
			'formSearch' => $formSearch -> createView(),
			'formNewEvent' => $formNewEvent -> createView()
		));
    }
	
	public function editEventAction (Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$session=$request->getSession();
		$listEvents=$session->get('listEvents');
		$searchService = $this->container->get('app.search');
		$eventFound = $searchService->searchInListById($listEvents, $id);
		$eventEdited = $em->merge($eventFound);

		$formEditEvent = $this->createForm(EventEditType::class, $eventEdited, array(
			'em' => $em,
			'action' => $this->generateUrl('ts_register_editevent', array('id'=>$id,'Request'=>$request))));
		
		if($request->isMethod('POST') && $formEditEvent->handleRequest($request)->isValid()) {
			//$eventForm = $request->request->get('event_edit');
			//$eventEdited->setStartDate($eventForm['startDate']);
			$em->flush();
			return $this->redirectToRoute('ts_register_homepage');
		}

		return $this->render('@TSRegister/Register/formEditEvent.html.twig', array(
			'event' => $eventEdited,
			'formEditEvent' => $formEditEvent -> createView()
		));
	}

	public function removeEventAction (Request $request, $id) {
		$em = $this->getDoctrine()->getManager();
		$session=$request->getSession();
		$listEvents=$session->get('listEvents');
		$searchService = $this->container->get('app.search');
		$event = $searchService->searchInListById($listEvents, $id);
		
		$em->remove($em->merge($event));
		$em->flush();

		return $this->redirectToRoute('ts_register_homepage');
	}

	public function listSubstationsAction ($id) {
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('TSAssetsBundle:Substation');
		$substations=$repository->getSubstations($id);
		$json = json_encode(array('substations' => $substations));
		$response = new Response();
		$response->headers->set('content-Type', 'application/json');
		$response->setContent($json);
		return $response;
	}
	public function listEquipmentsAction ($id) {
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository('TSAssetsBundle:Equipment');
		$equipments=$repository->getEquipments($id);
		$json = json_encode(array('equipment' => $equipments));
		$response = new Response();
		$response->headers->set('content-Type', 'application/json');
		$response->setContent($json);
		return $response;
	}

	public function manageEnsAction (Request $request) {
		$em = $this->getDoctrine()->getManager();
		$session = $request->getSession();
		$listSites = $em->getRepository('TSAssetsBundle:Site')->findAll();

		$search = new search();
		$formSearch = $this->get('form.factory')->create(SearchType::class, $search);
		
		if($request->isMethod('POST')) {
			if ($request->request->has('appbundle_search') && $formSearch->handleRequest($request)->isValid()) {
				$session->set('search', $search);
				
				$site = $search->getSite();
				$startDate = $search->getStartDate();
				$endDate = $search->getEndDate();

				$eventRepository = $em->getRepository('TSRegisterBundle:Event');
				$dataRowRepository = $em->getRepository('TSDataManagerBundle:ImportDataRow');
				$ensRepository = $em->getRepository('TSRegisterBundle:Ens');
				
				$losses = $ensRepository->getSelectedEns($startDate, $endDate, $site);
				$listEvents = [];
				foreach ($losses as $loss) {
					$event = $loss->getEvent();
					if (in_array($event, $listEvents)) {

					} else {
						$listEvents[] = $event;
					}
				}
				
				$session->set('listEvents', $listEvents);

				$rows = $dataRowRepository->getSelectedData($startDate, $endDate, $site);
				$session->set('rows', $rows);
				
				return $this->render('@TSRegister/Register/losses.html.twig', array(
					'listSites' => $listSites, 
					'listEvents' => $listEvents,
					'rows'=>$rows,
					'losses'=>$losses,
					'formSearch' => $formSearch -> createView()
				));
			}

			if ($request->request->has('ts_registerbundle_event') && $formNewEvent->handleRequest($request)->isValid()) {

				return $this->redirectToRoute('ts_register_homepage');
			}
		}
		$listEvents = $session->get('lisEvents');
		$rows = $session->get('rows');
		return $this->render('@TSRegister/Register/losses.html.twig', array(
			'listSites' => $listSites,
			'listEvents' => $listEvents,
			'rows'=>$rows,
			'formSearch' => $formSearch -> createView()
		));
	}

	public function saveAction(Request $request)
    {
        $tab= $request->getContent();
        $table = json_decode($tab);
		$em = $this->getDoctrine()->getManager();
		$ensRepository = $em->getRepository('TSRegisterBundle:Ens');
		$losses = [];
        foreach ($table as $ens) {
			foreach ($ens as $key => $cell){
				switch ($key){
                    case 'id':
						$loss = $ensRepository->find($cell);
						$losses[] = $loss;
                    break;
                    case 'value':
						$loss->setEnsOther($cell);
                    break;
                    default :
                }
			}
			$em->persist($loss);
        }
		$ensValidatorService = $this->container->get('ts_register.ensvalidator');
		$validation = $ensValidatorService->validateEns($losses);

		if ($validation) {
			$em->flush();
		}
        return $this->redirectToRoute('ts_register_homepage');
	}
}