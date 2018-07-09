<?php

namespace TS\RegisterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TS\RegisterBundle\Entity\Event;
use TS\AssetsBundle\Entity\Site;
use TS\RegisterBundle\Form\EventType;
use TS\RegisterBundle\Form\EventEditType;
use AppBundle\Entity\Search;
use AppBundle\Form\SearchType;

class RegisterController extends Controller{
    
	public function registerAction(Request $request){
		
		$em = $this->getDoctrine()->getManager();

		$listSites = $em->getRepository('TSAssetsBundle:Site')->findAll();

		$search = new search();
		$formSearch = $this->get('form.factory')->create(SearchType::class, $search);
				
		$event = new Event();
		$formNewEvent = $this->createForm(EventType::class, $event);

		if($request->isMethod('POST')) {
			if ($request->request->has('appbundle_search') && $formSearch->handleRequest($request)->isValid()) {
				$repository = $this
					->getDoctrine()
					->getManager()
					->getRepository('TSRegisterBundle:Event')
				;
				$startDate = $search->getStartDate();
				$endDate = $search->getEndDate();
				$listSites = $startDate;
				$listEvents = $repository->getSelectedEvents($startDate, $endDate);
				
				return $this->render('@TSRegister/Register/register.html.twig', array(
					'listSites' => $listSites, 
					'listEvents' => $listEvents,
					'formSearch' => $formSearch -> createView(),
					'formNewEvent' => $formNewEvent -> createView()
				));
			}
			if ($request->request->has('ts_registerbundle_event') && $formNewEvent->handleRequest($request)->isValid()) {
				$em->persist($event);
				$em->flush();

				return $this->redirectToRoute('ts_register_homepage');
			}
		}

		$listEvents = $em->getRepository('TSRegisterBundle:Event')->findAll();

		return $this->render('@TSRegister/Register/register.html.twig', array(
			'listSites' => $listSites, 
			'listEvents' => $listEvents,
			'formSearch' => $formSearch -> createView(),
			'formNewEvent' => $formNewEvent -> createView()
		));
    }
	
	public function editEventAction (Request $request, $id) {
		$eventEdited = new Event();
		$em = $this->getDoctrine()->getManager();
		$eventEdited = $em->getRepository('TSRegisterBundle:Event')->find($id);
		$formEditEvent = $this->createForm(EventEditType::class, $eventEdited, array(
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
		$event = new Event();
		$em = $this->getDoctrine()->getManager();
		$event = $em->getRepository('TSRegisterBundle:Event')->find($id);
		
		$em->remove($event);
		$em->flush();

		return $this->redirectToRoute('ts_register_homepage');
	}
}