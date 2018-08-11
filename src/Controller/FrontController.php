<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FrontController extends Controller
{

    /**
     * @Route("/", name="index", methods="GET")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response {

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT p FROM App:Product p";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );

        $repositoryCategory = $this->getDoctrine()->getRepository(Category::class);
        $category = $repositoryCategory->findAll();

        $repositorySlider = $this->getDoctrine()->getRepository(Product::class);
        $slider = $repositorySlider->findBySlider();

        return $this->render('front/index.html.twig', [
            'title' => 'Accueil',
            'pagination' => $pagination,
            'categories' => $category,
            'sliders' => $slider
        ]);
    }

    /**
     * @Route("/trois-produits", name="three-product", methods="GET")
     * @return Response
     */
    public function threeProduct(): Response {

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $threeProduct = $repository->findByThreeProduct();

        return $this->render('inc/three-product.html.twig', [
            'title' => '',
            'threeProduct' => $threeProduct
        ]);
    }

    /**
     * @Route("/boutique", name="shop", methods="GET")
     * @return Response
     */
    public function shop(): Response {

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->findAll();

        $repository2 = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository2->findAll();

        return $this->render('front/shop.html.twig', [
            'title' => 'Boutiques',
            'products' => $product,
            'categories' => $category
        ]);
    }

    /**
     * @Route("/soldes", name="soldes", methods="GET")
     * @return Response
     */
    public function soldes(): Response {

        return $this->render('front/soldes.html.twig', [
            'title' => 'Retrouvez ici tous les soldes du moment'
        ]);
    }

    /**
     * @Route("/qui-sommes-nous", name="about", methods="GET")
     * @return Response
     */
    public function about(): Response {

        return $this->render('front/about.html.twig', [
            'title' => 'Qui sommes nous ?'
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
    public function contact(): Response {

        return $this->render('front/contact.html.twig', [
           'title' => 'Contacter nous a tous moment si vous avez un problème !'
        ]);
    }

}