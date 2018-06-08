<?php

namespace TS\AssetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
}