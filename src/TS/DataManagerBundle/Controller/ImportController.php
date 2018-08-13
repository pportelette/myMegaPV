<?php

namespace TS\DataManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TS\DataManagerBundle\Form\UploadFileType;
use TS\DataManagerBundle\Entity\File;
use TS\DataManagerBundle\Entity\ImportDataRaw;

class ImportController extends Controller
{
    public function ImportAction(Request $request)
    {
        $tab = 'vide';
        $file = new file();
        $form = $this->get('form.factory')->create(UploadFileType::class, $file);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            
            $file->upload();
            $path = "../var/cache/dev/".$file->getName();

            $importService = $this->container->get('ts_data_manager.import');
            $tableau = $importService->importData($path);

            return $this->render('@TSDataManager/DataManager/import.html.twig', array(
                'form'=>$form->createview(),
                'tab'=>$tableau
            ));
        }
        return $this->render('@TSDataManager/DataManager/import.html.twig', array(
            'form'=>$form->createview(),
            'tab'=>$tab
        ));
    }

    public function saveAction(Request $request)
    {
        $tab= $request->getContent();
        $table = json_decode($tab);
        $em = $this->getDoctrine()->getManager();
        //ligne provisoire
        $site = $em->getRepository('TSAssetsBundle:Site')->find(1);
        
        foreach ($table as $raw) {
            $dataRaw = new importDataRaw();
            foreach ($raw as $key => $cell){
                switch ($key){
                    case 'date':
                        $format = str_replace("/", "-", $cell);
                        $days = strtotime($format);
                        $date = date('Y-m-d', $days);
                        $dateO = \DateTime::createFromFormat('Y-m-d', $date);
                        $dataRaw->setDate($dateO);
                    break;
                    case 'energy':
                        $dataRaw->setEnergyInjected($cell+0);
                    break;
                    case 'irradiation':
                        $dataRaw->setIrradiation($cell+0);
                    break;
                    default :
                }
            }
            $dataRaw->setSite($site);
            $em->persist($dataRaw);
        }
        $em->flush();

        return $this->render('@TSDataManager/DataManager/test.html.twig', array(
            'table'=>$table
        ));
    }
}
