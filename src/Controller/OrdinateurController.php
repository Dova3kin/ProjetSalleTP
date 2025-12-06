<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Type\OrdinateurType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Ordinateur;
use Doctrine\ORM\EntityManagerInterface;

final class OrdinateurController extends AbstractController
{
    #[Route('/ordinateur', name: 'app_ordinateur')]
    public function index(): Response
    {
        return $this->render('ordinateur/index.html.twig', [
            'controller_name' => 'OrdinateurController',
        ]);
    }

    #[Route('/ajout_ordinateur', name: 'ajout_ordinateur')]
    public function ajouter(EntityManagerInterface $entityManager, Request $request)
    {
        $ordinateur = new Ordinateur;
        $form = $this->createForm(OrdinateurType::class, $ordinateur);
        $form->add(
            'submit',
            SubmitType::class,
            array('label' => 'Ajouter')
        );
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $entityManager->persist($ordinateur);
            $entityManager->flush();
            return $this->redirectToRoute('ajout_ordinateur');
        }
        return $this->render(
            'ordinateur/ajouter.html.twig',
            array('monFormulaire' => $form->createView())
        );
    }
}
