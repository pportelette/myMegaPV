<?php

namespace TS\RegisterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TS\RegisterBundle\Entity\Event;
use TS\RegisterBundle\Form\EventType;

class RegisterController extends Controller{
    
		public function registerAction(Request $request){
		
		$em = $this->getDoctrine()->getManager();
		$listSites = array(
		  array('id' => 2, 'site' => 'Caillols'),
		  array('id' => 5, 'site' => 'Callian'),
		  array('id' => 9, 'site' => 'Figanieres')
		);
		$listEvents = $em->getRepository('TSRegisterBundle:Event')->findAll();

		//Creation of Event object for the formNewEvent
		$event = new Event();
		$formNewEvent = $this->createForm(EventType::class, $event, array(
			'action' => $this->generateUrl('ts_register_newevent', ['Request'=>$request])
		));
		
		$formEditEvent = $this->createForm(EventType::class, $event, array(
			'action' => $this->generateUrl('ts_register_editevent')
		));

		return $this->render('@TSRegister/Register/register.html.twig', array(
			'listSites' => $listSites, 
			'listEvents' => $listEvents,
			'formNewEvent' => $formNewEvent -> createView(),
			'formEditEvent' => $formEditEvent -> createView()));

    }
	
	public function editEventAction(Request $request){

		if ($request->isMethod('POST') && $formEditEvent->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($event);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
		}
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
}