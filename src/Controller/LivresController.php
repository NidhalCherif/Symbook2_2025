<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use function PHPUnit\Framework\throwException;

final class LivresController extends AbstractController
{
    #[Route('/livres/delete/{id}', name: 'app_livres_delete')]
    public function delete(Livres $livre,EntityManagerInterface $em): Response
    {
        $em->remove($livre);
        $em->flush();
        dd($livre);
    }
    #[Route('/livres/update/{id}', name: 'app_livres_upadate')]
    public function update(Livres $livre,EntityManagerInterface $em): Response
    { //$livre = $rep->find($id);
        $nouveauPrix=$livre->getPrix()*1.1;
        $livre->setPrix($nouveauPrix);
        $em->persist($livre);

        $em->flush();

        dd($livre);
    }
    #[Route('/livres', name: 'app_livres')]
    public function all(LivresRepository $rep): Response
    { $livres=$rep->findAll();
        //dd($livres);
        return $this->render('livres/all.html.twig', ['livres'=>$livres]);
    }
    #[Route('/livres/show/{id}', name: 'app_livres_show')]
    //paramConverter
    public function show(Livres $livre): Response
    {
        if(!$livre)
        {throw $this->createNotFoundException('No book found for id '.$id);}

        dd($livre);
    }
    #[Route('/livres/show2', name: 'app_livres_show2')]
    public function show2(LivresRepository $rep): Response
    { $livre=$rep->findOneBy(['titre'=>'titre 1','editeur'=>'Eni']);

        dd($livre);
    }
    #[Route('/livres/show3', name: 'app_livres_show3')]
    public function show3(LivresRepository $rep): Response
    { $livres=$rep->findBy(['titre'=>'titre 1','editeur'=>'Eyrolles'],['prix'=>'DESC']);

        dd($livres);
    }



    #[Route('/livres/create', name: 'app_livres_create')]
    public function create(EntityManagerInterface $em): Response
    {$livre=new Livres();
        $date=new \DateTime("2023-02-02");
        $livre->setTitre('titre 1')
            ->setSlug('titre-1')
            ->setImage('https://picsum.photos/200/?id=1')
            ->setResume('resume 1')
            ->setEditeur('Eni')
            ->setDateEdition($date)
            ->setIsbn('111-111-1111-1111')
            ->setPrix(200);
        $em->persist($livre);
        $em->flush();// insertion dans la base par doctrine les objets persistés
        return new Response("created new book with id {$livre->getId()}");



    }

}
