<?php

namespace TS\AssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use TS\AssetsBundle\Entity\Inverter;
use TS\AssetsBundle\Form\InverterType;

class AssetsController extends Controller{
    
	public function assetsAction()
	{		
		$em = $this->getDoctrine()->getManager();
		$listClients = $em->getRepository('TSAssetsBundle:Client')->findAll();

		return $this->render('@TSAssets/Assets/assets.html.twig', array(
			'listClients'=>$listClients		
		));
	}
	
	public function getSiteAction(Request $req, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$listAssets = [];
		$substations = $em->getRepository('TSAssetsBundle:Site')->find($id)->getSubstations();
		for ($i=0; $i<count($substations); $i++){
			$inverters = $em->getRepository('TSAssetsBundle:Substation')->find($substations[$i]->getId())->getEquipments();
			$sub = $substations[$i]->getName();
			
			if (count($inverters) != 0){
				$inverterstab=[];
				foreach ($inverters as $inverter) {
					$inverterstab[] = $inverter->getName();
				}
				$poste=array('name' =>$sub, 'inverters' => $inverterstab);	
			}
			else {
				$inv=[];
				$poste=array('name' =>$sub, 'inverters' => $inv);
			}
			$listAssets[]=$poste;
		}
		$json = json_encode(array('listAssets' => $listAssets));
		$response = new Response();
		$response->headers->set('content-Type', 'application/json');
		$response->setContent($json);
		return $response;
	}
	
	public function newEquipmentAction(Request $request) {
		$inverter = new Inverter();
		$form = $this->get('form.factory')->create(InverterType::class, $inverter);
		if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($inverter);
			$em->flush();

			return $this->redirectToRoute('ts_assets_homepage');
		}
		return $this->render('@TSAssets/Assets/formInverter.html.twig', array(
			'form' => $form -> createView()		
		));
	}
}