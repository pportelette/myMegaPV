<?php

namespace TS\AssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class AssetsController extends Controller{
    
	public function assetsAction(){
		
		$em = $this->getDoctrine()->getManager();
		$listClients = $em->getRepository('TSAssetsBundle:Client')->findAll();
		$listSites = $em->getRepository('TSAssetsBundle:Site')->findAll();

		return $this->render('@TSAssets/Assets/assets.html.twig', array(
			'listClients'=>$listClients,
			'listSites'=> $listSites			
		));

	}
	
	public function getSiteAction(Request $req, $id){

		$em = $this->getDoctrine()->getManager();
		$listAssets = $em->getRepository('TSAssetsBundle:Substation')->getSubstations($id);
		$json = json_encode(array('listAssets' => $listAssets));
		$response = new Response();
		$response->headers->set('content-Type', 'application/json');
		$response->setContent($json);
		return $response;

    }
}