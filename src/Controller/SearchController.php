<?php
namespace App\Controller;

use App\Entity\Product;
use App\Form\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends Controller {

    /**
     * @Route("/recherche/", name="search")
     * @param Request $request
     * @return Response
     */
    public function recherche(Request $request): Response {

        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $contentSearch = $form->getData();
            $value = $contentSearch['name'];
            $search = $this->getDoctrine()->getRepository(Product::class)->findBySearch($value);

            return $this->render('inc/header.html.twig', [
                'title' => 'Résultat de votre recherche',
                'resultSearch' => $search
            ]);
        }

        return $this->render('inc/search.html.twig', [
            'title' => 'Effectué une recherche de vos produits',
            'search' => $form->createView()
        ]);
    }
}