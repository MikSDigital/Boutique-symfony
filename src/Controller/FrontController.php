<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FrontController extends Controller
{

    /**
     * @Route("/", name="index", methods="GET")
     * @return Response
     */
    public function index(): Response {

        return $this->render('front/index.html.twig', [
            'title' => 'Accueil'
        ]);
    }

    /**
     * @Route("/boutique", name="shop", methods="GET")
     * @return Response
     */
    public function shop(): Response {

        return $this->render('front/shop.html.twig', [
            'title' => 'Boutiques'
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