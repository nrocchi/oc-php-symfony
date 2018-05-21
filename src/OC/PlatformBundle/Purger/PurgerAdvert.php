<?php
// src/OC/PlatformBundle/Purger/PurgerAdvert.php

namespace OC\PlatformBundle\Purger;

use Doctrine\ORM\EntityManagerInterface;

class PurgerAdvert
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function purge($days)
    {
        // on récupère les annonces à purger
        $listAdvertsToPurge = $this->em
            ->getRepository('OCPlatformBundle:Advert')
            ->getAdvertsToPurge(new \Datetime('-'.$days.' day'));

        foreach ($listAdvertsToPurge as $advertToPurge) {

            // on récupère les advertskills pour chaque annonce
            $listAdvertSkills = $this->em
                ->getRepository('OCPlatformBundle:AdvertSkill')
                ->findBy(array('advert' => $advertToPurge));

            // on supprime les advertskills de chaque annonce à purger
            foreach ($listAdvertSkills as $advertSkill) {
                $this->em->remove($advertSkill);
            }

            // on supprime l'annonce
            $this->em->remove($advertToPurge);
        }

        // on met à jour la bdd
        $this->em->flush();
    }
}
