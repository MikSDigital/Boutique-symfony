<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ProductType;
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
     * @Route("/listes-des-produits", name="show-product", methods="GET")
     * @return Response
     */
    public function showProduct(): Response {

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->findAll();

        return $this->render('back/show-product.html.twig', [
            'title' => 'Listes de tous les produits disponibles',
            'products' => $product
        ]);
    }

    /**
     * @Route("/categorie/ajouter", name="add-category", methods="POST|GET")
     * @param Request
     * @return Response
     */
    public function addCategory(Request $request): Response {

        $manager = $this->getDoctrine()->getRepository(Category::class);
        $showCategory = $manager->findAll();

        $category = new Category();
        $addCategory = $this->createForm(CategoryType::class, $category);
        $addCategory->handleRequest($request);

        if($addCategory->isSubmitted() && $addCategory->isValid()) {

            $category = $addCategory->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();

            $this->addFlash('category', 'La catégorie à bien été ajouté.');
            return $this->redirectToRoute('add-category');
        }

        return $this->render('back/CRUD/add-category.html.twig', [
            'title' => 'Ajouter une categorie',
            'addCategory' => $addCategory->createView(),
            'showCategory' => $showCategory
        ]);
    }

    /**
     * @Route("/produits/ajouter", name="add-product", methods="POST|GET")
     * @param Request
     * @return Response
     */
    public function addProduct(Request $request): Response {

        $product = new Product();
        $addProduct = $this->createForm(ProductType::class, $product);
        $addProduct->handleRequest($request);

        if($addProduct->isSubmitted() && $addProduct->isValid()) {
            $product = $addProduct->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($product);
            $manager->flush();

            $this->addFlash('product', 'Le produits à bien été ajouté');
            return $this->redirectToRoute('index_back_office');
        }

        return $this->render('back/CRUD/add-product.html.twig', [
            'title' => 'Ajouter un produit a votre boutique',
            'addProduct' => $addProduct->createView()
        ]);
    }




}