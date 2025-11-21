<?php

namespace App\Controller;

use App\Entity\Salle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;

class SalleController extends AbstractController
{
    public function accueil(Session $session)
    {
        if ($session->has('nbreFois'))
            $session->set('nbreFois', $session->get('nbreFois') + 1);
        else
            $session->set('nbreFois', 1);
        return $this->render('salle/accueil.html.twig', array('nbreFois' => $session->get('nbreFois')));
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

    public function voir(EntityManagerInterface $entityManager, $id)
    {
        $salle = $entityManager->getRepository(Salle::class)->find($id);
        if (!$salle)
            throw $this->createNotFoundException('Salle[id=' . $id . '] inexistante');
        return $this->render(
            'salle/voir.html.twig',
            ['salle' => $salle]
        );
    }

    public function ajouter(
        EntityManagerInterface $entityManager,
        $batiment,
        $etage,
        $numero
    ) {
        $salle = new Salle;
        $salle->setBatiment($batiment);
        $salle->setEtage($etage);
        $salle->setNumero($numero);
        $entityManager->persist($salle);
        $entityManager->flush();
        return $this->redirectToRoute(
            'salle_tp_voir',
            array('id' => $salle->getId())
        );
    }

    public function ajouter2(EntityManagerInterface $entityManager, Request $request, Session $session)
    {
        $salle = new Salle;
        $form = $this->createFormBuilder($salle)
            ->add('batiment', TextType::class)
            ->add('etage', IntegerType::class)
            ->add('numero', IntegerType::class)
            ->add('envoyer', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($salle);
            $entityManager->flush();
            $session->getFlashBag()->add('infoAjout', 'nouvelle salle ajoutée :' . $salle);
            return $this->redirectToRoute('salle_tp_voir', array('id' => $salle->getId()));
        }
        return $this->render(
            'salle/ajouter2.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }

    public function navigation(EntityManagerInterface $entityManager)
    {
        $salles = $entityManager
            ->getRepository(Salle::class)->findAll();
        return $this->render('salle/navigation.html.twig', array('salles' => $salles));
    }
}
