<?php

namespace App\Controller;

use App\Entity\Salle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleController extends AbstractController
{
    public function accueil()
    {
        $nombre = rand(1, 100);
        return $this->render('salle\accueil.html.twig', ['numero' => $nombre]);
    }

    public function afficher($numero)
    {
        if ($numero > 50) {
            throw $this->createNotFoundException("Error : nombre trop élevé");
        } else
            return $this->render('salle\afficher.html.twig', ['numero' => $numero]);
    }

    public function dix()
    {
        return $this->redirectToRoute('salle_tp_afficher', array('numero' => 10));
    }

    public function treize()
    {
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(1);
        $salle->setNumero(13);
        return $this->render('salle/treize.html.twig', ['salle' => $salle]);
    }

    public function quatorze()
    {
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(1);
        $salle->setNumero(14);
        return $this->render('salle/quatorze.html.twig', ['designation' => $salle]);
    }
}
