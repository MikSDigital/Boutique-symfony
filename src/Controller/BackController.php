<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends Controller
{

    public function index(): Response {

        return $this->render('back/index.html.twig', [
            'title' => 'Bienvenue dans votre back-Office'
        ]);
    }

}