<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Search;
use TS\AssetsBundle\Entity\Site;

class AppController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $siteRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TSAssetsBundle:Site')
        ;

        $search = new Search();
        $startDate = new \DateTime('2018-01-01');
        $endDate = new \DateTime('2018-01-31');

        $site = $siteRepository->find(1);

        $search->setStartDate($startDate);
        $search->setEndDate($endDate);
        $search->setSite($site);

        $session=$request->getSession();
        $session->set('search', $search);

        $rowsRepository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('TSDataManagerBundle:ImportDataRow')
        ;
        $rows = $rowsRepository->getSelectedData($search->getStartDate(), $search->getEndDate(), $site);
        $session->set('rows', $rows);

        return $this->render('@App/App/homepage.html.twig');
    }
}
