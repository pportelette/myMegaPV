<?php

namespace TS\AssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use TS\AssetsBundle\Entity\Inverter;
use TS\AssetsBundle\Form\InverterType;
use TS\AssetsBundle\Form\InverterEditType;
use TS\AssetsBundle\Entity\Ppc;
use TS\AssetsBundle\Form\PpcType;
use TS\AssetsBundle\Form\PpcEditType;

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
		foreach ($substations as $substation) {
			$equipments = $substation->getEquipments();
			$sub = $substation->getName();
			
			if (count($equipments) != 0){
				$equipmentstab=[];
				$equipmentsId=[];
				foreach ($equipments as $equipment) {
					$equipmentstab[] = $equipment->getName();
					$equipmentsId[] = $equipment->getId();
				}
				$poste=array('name' =>$sub, 'equipments' => $equipmentstab, 'id' => $equipmentsId);	
			}
			else {
				$equ=[];
				$equId=[];
				$poste=array('name' =>$sub, 'equipments' => $equ, 'id' => $equId);
			}
			$listAssets[]=$poste;
		}
		$json = json_encode(array('listAssets' => $listAssets));
		$response = new Response();
		$response->headers->set('content-Type', 'application/json');
		$response->setContent($json);
		return $response;
	}

	public function getEquipmentAction(Request $req, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$equipment = $em->getRepository('TSAssetsBundle:Equipment')->find($id);
		$type = get_class($equipment);
		switch ($type) {
			case 'TS\AssetsBundle\Entity\Inverter':
				$form = $this->get('form.factory')->create(InverterEditType::class, $equipment);
			break;
			case 'TS\AssetsBundle\Entity\Ppc':
				$form = $this->get('form.factory')->create(PpcEditType::class, $equipment);
			break;
		}
		return $this->render('@TSAssets/Assets/formEquipment.html.twig', array(
			'form' => $form -> createView()
		));
	}
	
	public function newEquipmentAction(Request $request, $asset) {
		switch ($asset) {
			case "inverter":
				$equipment = new Inverter();
				$formType = InverterType::class;
			case "ppc":
				$equipment = new Ppc();
				$formType = PpcType::class;
		}
		$form = $this->get('form.factory')->create($formType, $equipment);
		if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($equipment);
			$em->flush();

			return $this->redirectToRoute('ts_assets_homepage');
		}
		return $this->render('@TSAssets/Assets/formInverter.html.twig', array(
			'form' => $form -> createView()		
		));
	}
}