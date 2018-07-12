<?php

namespace TS\AssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class AssetsController extends Controller{
    
	public function assetsAction()
	{		
		$em = $this->getDoctrine()->getManager();
		$listClients = $em->getRepository('TSAssetsBundle:Client')->findAll();
		$listSites = $em->getRepository('TSAssetsBundle:Site')->findAll();

		return $this->render('@TSAssets/Assets/assets.html.twig', array(
			'listClients'=>$listClients,
			'listSites'=> $listSites			
		));
	}
	
	public function getSiteAction(Request $req, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$listAssets = [];
		$substations = $em->getRepository('TSAssetsBundle:Site')->find($id)->getSubstations();
		for ($i=0; $i<count($substations); $i++){
			$inverters = $em->getRepository('TSAssetsBundle:Substation')->find($substations[$i]->getId())->getInverters();
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
}