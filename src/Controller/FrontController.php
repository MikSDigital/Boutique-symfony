<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\RandomMessage;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $dql   = "SELECT p FROM App:Product p WHERE p.isPublished = :boolean";
        $query = $em->createQuery($dql);
        $query->setParameter('boolean', '1');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            16/*limit per page*/
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
     * @Route("/boutique", name="shop", methods="GET")
     * @param Request $request
     * @return Response
     */
    public function shop(Request $request): Response {

        $em    = $this->get('doctrine.orm.entity_manager');
        $dql   = "SELECT p FROM App:Product p WHERE p.isPublished = :boolean";
        $query = $em->createQuery($dql);
        $query->setParameter('boolean', '1');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            16/*limit per page*/
        );

        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findAll();

        return $this->render('front/shop.html.twig', [
            'title' => 'Boutiques',
            'pagination' => $pagination,
            'categories' => $category
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
     * @Route("/produits/{slug}", name="show-product-front", methods="GET")
     * @param string $slug
     * @return Response
     */
    public function showProduct(string $slug): Response {

        $product = $this->getDoctrine()->getRepository(Product::class)->findOneWithCategorySlug($slug);
        $productInCategory = $this->getDoctrine()->getRepository(Product::class)->findProductByCategory();

        return $this->render('front/product.html.twig', [
            'title' => '',
            'showProduct' => $product,
            'showProductInCategory' => $productInCategory
        ]);
    }

    /**
     * @Route("/produits-views/", name="product-views", methods="GET")
     * @param int $id
     * @return Response
     */
    public function viewsProduct(int $id): Response {

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render('inc/views-product.html.twig', [
            'productViews' => $product
        ]);
    }

    /**
     * @Route("/message-dynamique/", name="random-message-front", methods="GET")
     * @return Response
     */
    public function randomMessage(): Response {

        $randomMessage = $this->getDoctrine()->getRepository(RandomMessage::class)->findByMessage();

        return $this->render('inc/random-message.html.twig', [
            'title' => '',
            'randomMessage' => $randomMessage
        ]);
    }

    /**
     * @Route("/json", name="test", methods="GET")
     * @param JsonResponse
     * @return JsonResponse
     */
    public function jsonTest(): JsonResponse {
        $repositoryCategory = $this->getDoctrine()->getRepository(Category::class);
        $category = $repositoryCategory->findAll();

        return new JsonResponse(array('data' => json_encode($category)));

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

    /**
     * @Route("/recherche/", name="search", methods="POST")
     * @param Request $request
     * @return Response
     */
    public function search(Request $request): Response{

        $search = $this->createForm(SearchType::class);
        $search->handleRequest($request);

        if($request->isXmlHttpRequest()) {

           $value = $search['name'];
           $result = $this->getDoctrine()->getRepository(Product::class)->findBySearch($value);

            return new JsonResponse(['data' => json_encode($result)]);
        }

        return $this->render('inc/search.html.twig', [
            'title' => 'Effectuer une recherche',
            'search' => $search->createView()
        ]);

    }



}