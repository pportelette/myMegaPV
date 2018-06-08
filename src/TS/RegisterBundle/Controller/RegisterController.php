<?php

namespace TS\RegisterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use TS\RegisterBundle\Entity\Event;
use TS\AssetsBundle\Entity\Site;
use TS\RegisterBundle\Form\EventType;
use TS\RegisterBundle\Form\EventEditType;

class RegisterController extends Controller{
    
		public function registerAction(Request $request){
		
		$em = $this->getDoctrine()->getManager();
		$listSites = $em->getRepository('TSAssetsBundle:Site')->findAll();
		$listEvents = $em->getRepository('TSRegisterBundle:Event')->findAll();

		$event = new Event();
		$formNewEvent = $this->createForm(EventType::class, $event, array(
			'action' => $this->generateUrl('ts_register_newevent', ['Request'=>$request])
		));
		
		$formEditEvent = $this->createForm(EventEditType::class, $event, array(
			'action' => $this->generateUrl('ts_register_editevent', ['Request'=>$request])
		));

		return $this->render('@TSRegister/Register/register.html.twig', array(
			'listSites' => $listSites, 
			'listEvents' => $listEvents,
			'formNewEvent' => $formNewEvent -> createView(),
			'formEditEvent' => $formEditEvent -> createView()));

    }
	
	public function editEventAction(Request $request){
		$event = new Event();
		$formEditEvent = $this->createForm(EventEditType::class, $event)->handleRequest($request);
		if ($formEditEvent->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($event);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

			return $this->redirectToRoute('ts_register_homepage');
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