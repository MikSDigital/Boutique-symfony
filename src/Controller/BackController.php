<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */

class BackController extends Controller
{

    /**
     * @Route("/", name="index_back_office", methods="GET")
     * @return Response
     */
    public function index(): Response {

        return $this->render('back/index.html.twig', [
            'title' => 'Bienvenue dans votre back-Office'
        ]);
    }

    /**
     * @Route("/categorie/ajouter", name="add-category", methods="POST|GET")
     * @param Request
     * @return Response
     */
    public function addCategory(Request $request): Response {

        $category = new Category();
        $addCategory = $this->createForm(CategoryType::class, $category);
        $addCategory->handleRequest($request);

        if($addCategory->isSubmitted() && $addCategory->isValid()) {

            $category = $addCategory->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('category', 'La catégorie à bien été ajouté.');
            return $this->redirectToRoute('index_back_office');
        }

        return $this->render('back/CRUD/add-category.html.twig', [
            'title' => 'Ajouter une categorie',
            'addCategory' => $addCategory->createView()
        ]);
    }




}