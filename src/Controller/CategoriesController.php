<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategorieType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategoriesController extends AbstractController
{
    #[Route('/admin/categories', name: 'admin_categories')]
    public function index(CategoriesRepository $rep): Response
    {   $categories = $rep->findAll();
        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/admin/categories/create', name: 'admin_categories_create')]
    public function create(Request $request,EntityManagerInterface $em): Response
    {   $categorie=new Categories();
        //afficher le formulaire
        $form=$this->createForm(CategorieType::class,$categorie);
        //traitement des données issues
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($categorie);
            $em->flush();
            $this->addFlash('success','La catégorie a été bien ajoutée');
            return $this->redirectToRoute('admin_categories');


        }

        return $this->render('categories/create.html.twig', [
            'f' => $form,
        ]);
    }
    #[Route('/admin/categories/update/{id}', name: 'admin_categories_update')]
    public function update(Request $request,EntityManagerInterface $em,Categories $categorie): Response
    {
        //afficher le formulaire
        $form=$this->createForm(CategorieType::class,$categorie);
        //traitement des données issues
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();
            $this->addFlash('success','La catégorie a été bien modifiée');
            return $this->redirectToRoute('admin_categories');


        }

        return $this->render('categories/update.html.twig', [
            'f' => $form,
        ]);
    }

}
