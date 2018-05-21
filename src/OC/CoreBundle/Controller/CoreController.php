<?php

// src/OC/CoreBundle/Controller/CoreController.php

namespace OC\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {

        $listAdverts = $this->getDoctrine()
            ->getManager()
            ->getRepository('OCPlatformBundle:Advert')
            ->myFindAll()
        ;

        // On donne toutes les informations nécessaires à la vue
        return $this->render('OCCoreBundle:Core:index.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }

    public function contactAction(Request $request)
    {
        $session = $request->getSession();

        $session->getFlashBag()->add('contact', 'Désolé, la page de contact n\'est pas encore disponible.');

        return $this->redirectToRoute('oc_core_home');
    }
}