<?php

namespace TS\RegisterBundle\Services\EnsValidator;

use Doctrine\ORM\EntityManager;

class EnsValidator
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function validateEns($losses)
    {
        $prevEvent = null;
        $event = $losses[0]->getEvent();
        $site = $event->getSite();
        $listEvents = [];
        foreach($losses as $loss) {
            $event = $loss->getEvent();
            if ($event === $prevEvent) {
                $event->addEns($loss->getEnsOther());
            } else {
                $listEvents[] = $prevEvent;
                $prevEvent = $event;
                $event->setEns($loss->getEnsOther());
            }
        }
        foreach ($listEvents as $currentEvent) {
            $em->persist($currentEvent);
        }
        $em->flush();
        return false;
    }

}