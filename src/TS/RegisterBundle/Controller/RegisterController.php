<?php

namespace TS\RegisterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TS\RegisterBundle\Entity\Event;
use TS\AssetsBundle\Entity\Site;
use TS\RegisterBundle\Form\EventType;

class RegisterController extends Controller{
    
	public function registerAction(Request $request){
		
		$em = $this->getDoctrine()->getManager();
		$listSites = $em->getRepository('TSAssetsBundle:Site')->findAll();
		$listEvents = $em->getRepository('TSRegisterBundle:Event')->findAll();

		$event = new Event();
		$formNewEvent = $this->createForm(EventType::class, $event, array(
			'action' => $this->generateUrl('ts_register_newevent', ['Request'=>$request])
		));
		
		$formEditEvent = $this->createForm(EventType::class, $event);
		
		return $this->render('@TSRegister/Register/register.html.twig', array(
			'listSites' => $listSites, 
			'listEvents' => $listEvents,
			'formNewEvent' => $formNewEvent -> createView()
		));
    }
	
	public function editEventAction(Request $request, $id){
		//$event = new Event();
		$em = $this->getDoctrine()->getManager();
		//$event->setId($id);
		//$formEditEvent = $this->createForm(EventType::class, $event);
		//if ($formEditEvent->handleRequest($request)->isValid()) {
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

			return $this->redirectToRoute('ts_register_homepage');
		//}
	}
	
	public function newEventAction(Request $request){
		$event = new Event();
		$formNewEvent = $this->createForm(EventType::class, $event)->handleRequest($request);
		if ($formNewEvent->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($event);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

			return $this->redirectToRoute('ts_register_homepage');
		}
    }

	public function getEventAction (Request $request, $id) {
		$event = new Event();
		$em = $this->getDoctrine()->getManager();
		$event = $em->getRepository('TSRegisterBundle:Event')->find($id);
		$formEditEvent = $this->createForm(EventType::class, $event, array(
			'action' => $this->generateUrl('ts_register_editevent', array('id'=>$id, 'Request'=>$request))));
		
		return $this->render('@TSRegister/Register/formEditEvent.html.twig', array(
			'event' => $event,
			'formEditEvent' => $formEditEvent -> createView()
		));
	}
}