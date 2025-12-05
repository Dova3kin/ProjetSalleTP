<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Salle;
use App\Entity\Ordinateur;
use Doctrine\ORM\EntityManagerInterface;

final class EssaiController extends AbstractController
{
    #[Route('/essai', name: 'app_essai')]
    public function index(): Response
    {
        return $this->render('essai/index.html.twig', [
            'controller_name' => 'EssaiController',
        ]);
    }

    public function test1(EntityManagerInterface $entityManager)
    {
        $salleA = new Salle;
        $salleA->setBatiment('D');
        $salleA->setEtage(7);
        $salleA->setNumero(70);
        $entityManager->persist($salleA);
        $result = 'persist salleA: ' . $salleA . ' id :' . $salleA->getId() . '<br />';
        $salleB = new Salle;
        $salleB->setBatiment('D');
        $salleB->setEtage(7);
        $salleB->setNumero(69);
        $result .= 'salleB ... ' . $salleB . ' id :' . $salleB->getId() . '<br />';
        $entityManager->flush();
        $result .= 'flush –-- id salleA:' . $salleA->getId()
            . ' id salleB:' . $salleB->getId() . '<br />';
        $salle2A = $entityManager->getRepository(Salle::class)
            ->find($salleA->getId());
        if ($salle2A !== null)
            $result .= 'find(' . $salleA->getId() . ') ' . $salle2A . '<br />';
        return new Response('<html><body>' . $result . '</body></html>');
    }

    public function test2(EntityManagerInterface $entityManager)
    {
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(73);
        $entityManager->persist($salle);
        $salle->setNumero($salle->getNumero() + 1);
        $entityManager->flush();
        $salle2 = $entityManager->getRepository(Salle::class)
            ->find($salle->getId());
        return new Response('<html><body>' . $salle2 . '</body></html>');
    }

    public function test3(EntityManagerInterface $entityManager)
    {
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(75);
        $entityManager->persist($salle);
        $result = 'persist ' . $salle . '<br />';
        $entityManager->flush();
        $id = $salle->getId();
        $result .= 'flush id:' . $id . ' --- contains:' . $entityManager->contains($salle)
            . '<br />';
        $entityManager->clear();
        $result .= 'clear --- contains:' . $entityManager->contains($salle) . '<br/>';
        $repo = $entityManager->getRepository(Salle::class);
        $salle = $repo->find($id);
        $result .= 'find(' . $id . ') --- contains(cette salle):'
            . $entityManager->contains($salle) . '<br />';
        return new Response('<html><body>' . $result . '</body></html>');
    }

    public function test4(EntityManagerInterface $entityManager)
    {
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(75);
        $entityManager->persist($salle);
        $result = 'persist ' . $salle . '<br />';
        $entityManager->flush();
        $id = $salle->getId();
        $result .= 'flush id de la salle:' . $id . '<br /> contains salle:'
            . $entityManager->contains($salle) . '<br />';
        $entityManager->detach($salle);
        $result .= 'detach salle ---> contains:' . $entityManager->contains($salle) . '<br />';
        $salle = $entityManager->getRepository(Salle::class)->find($id);
        $result .= 'find(' . $id . ') --- contains(cette salle):'
            . $entityManager->contains($salle) . '<br />';
        return new Response('<html><body>' . $result . '</body></html>');
    }

    public function test5(EntityManagerInterface $entityManager)
    {
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(7);
        $salle->setNumero(76);
        $entityManager->persist($salle);
        $result = 'persist ' . $salle . '<br />';
        $entityManager->flush();
        $id = $salle->getId();
        $result .= 'flush ----- id:' . $id . '<br />';
        $repo = $entityManager->getRepository(Salle::class);
        $salle = $repo->find($id);
        $result .= 'find(' . $id . ') --- salle:' . $salle . '<br />';
        $entityManager->remove($salle);
        $entityManager->flush();
        $result .= 'remove salle puis flush<br />' . 'find(' . $id . ')='
            . $repo->find($id) . '<br />' . 'contains(salle):' . $entityManager->contains($salle);
        return new Response("<html><body>$result</body></html>");
    }

    public function test6(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $salle = $repo->find(1);
        dump($salle);
        return new Response('<html><body></body></html>');
    }

    public function test7(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $salles = $repo->findAll();
        dump($salles);
        return new Response('<html><body></body></html>');
    }

    public function test8(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $salles = $repo->findBy(
            array('etage' => 1),
            array('numero' => 'asc'),
            2,
            1
        );
        dump($salles);
        return new Response('<html><body></body></html>');
    }

    public function test9(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $salle = $repo->findOneBy(array('etage' => 1));
        dump($salle);
        return new Response('<html><body></body></html>');
    }

    public function test10(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $salles = $repo->findByBatiment('B');
        dump($salles);
        return new Response('<html><body></body></html>');
    }

    public function test11(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $salle = $repo->findOneByEtage(1);
        dump($salle);
        return new Response('<html><body></body></html>');
    }

    public function test12(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $salles = $repo->findByBatimentAndEtageMax('D', 6);
        dump($salles);
        return new Response('<html><body></body></html>');
    }

    public function test13(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $salles = $repo->findSalleBatAouB();
        dump($salles);
        return new Response('<html><body></body></html>');
    }

    public function test14(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $result = $repo->plusUnNumero();
        return new Response('<html><body><a href="http://localhost/phpmyadmin">
 voir phpmyadmin</a></body></html>');
    }

    public function test16(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $result = $repo->testGetResult();
        dump($result);
        return new Response('<html><body></body></html>');
    }

    public function test19(EntityManagerInterface $entityManager)
    {
        $repo = $entityManager->getRepository(Salle::class);
        $result = $repo->testGetSingleScalarResult();
        dump($result);
        return new Response('<html><body></body></html>');
    }

    public function test23(EntityManagerInterface $entityManager)
    {
        $salle = new Salle;
        $salle->setBatiment('b'); // minuscule !
        $salle->setEtage(3);
        $salle->setNumero(63);
        $entityManager->persist($salle);
        $entityManager->flush();
        return $this->redirectToRoute(
            'salle_tp_voir',
            array('id' => $salle->getId())
        );
    }

    public function test25(EntityManagerInterface $entityManager)
    {
        $salle = $entityManager->getRepository(Salle::class)->findOneBy(array(
            'batiment' => 'D',
            'etage' => 7,
            'numero' => 71
        ));
        $ordi = new Ordinateur;
        $ordi->setNumero(702);
        $ordi->setIp('192.168.7.02');
        $ordi->setSalle($salle);
        $entityManager->persist($ordi);
        $entityManager->flush();
        dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test26(EntityManagerInterface $em)
    {
        $salle = new Salle;
        $salle->setBatiment('B');
        $salle->setEtage(0);
        $salle->setNumero(0);
        $ordi = new Ordinateur;
        $ordi->setNumero(701);
        $ordi->setIp('192.168.7.01');
        $ordi->setSalle($salle);
        $em->persist($ordi);
        $em->flush();
        dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test27(EntityManagerInterface $em)
    {
        $salle = new Salle;
        $salle->setBatiment('B');
        $salle->setEtage(0);
        $salle->setNumero(1);
        $ordi = new Ordinateur;
        $ordi->setNumero(703);
        $ordi->setIp('192.168.7.03');
        $ordi->setSalle($salle);
        $em->persist($ordi);
        $em->flush();
        dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test28(EntityManagerInterface $em)
    {
        $ordi = $em->getRepository(Ordinateur::class)->findOneByNumero(703);
        dump($ordi);
        $batiment = $ordi->getSalle()->getBatiment();
        dump($batiment);
        dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test29(EntityManagerInterface $em)
    {
        $ordi = new Ordinateur;
        $ordi->setNumero(803);
        $ordi->setIp('192.168.8.04');
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(8);
        $salle->setNumero(03);
        $salle->addOrdinateur($ordi);
        $em->persist($ordi);
        $em->flush();
        $ordi = $salle = null;
        $ordi = $em->getRepository(Ordinateur::class)->findOneByNumero(803);
        dump($ordi);
        return new Response('<html><body></body></html>');
    }

    public function test30(EntityManagerInterface $em)
    {
        $ordi = new Ordinateur;
        $ordi->setNumero(804);
        $ordi->setIp('192.148.8.04');
        $em->persist($ordi);
        $salle = new Salle;
        $salle->setBatiment('D');
        $salle->setEtage(8);
        $salle->setNumero(8);
        $salle->addOrdinateur($ordi);
        $em->persist($salle);
        $em->flush();
        dump($ordi);
        return new Response('<html><body></body></html>');
    }
}
