<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{
    public function index(): Response {

        return $this->render('front/index.html.twig', [
            'title' => 'Accueil'
        ]);
    }
}