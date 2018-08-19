<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\RandomMessage;
use App\Form\CategoryType;
use App\Form\ProductType;
use App\Form\RandomMessageType;
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
     * @Route("/listes-des-produits", name="listes-product", methods="GET")
     * @return Response
     */
    public function listesProduct(): Response {

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->findAll();

        return $this->render('back/listes-product.html.twig', [
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
     * @Route("/categorie/modifier/{id}", name="edit-category", methods="GET|POST", requirements={"page"="\d+"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editCategory(Request $request, int $id): Response {

        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $editCategory = $this->createForm(CategoryType::class, $category);
        $editCategory->handleRequest($request);

        if($editCategory->isSubmitted() && $editCategory->isValid()) {
            $category = $editCategory->getData();
            $categories = $this->getDoctrine()->getManager();
            $categories->flush();
            $this->addFlash('Category', 'La catégorie a bien été modifié');
            return $this->redirectToRoute('add-category');
        }
        return $this->render('back/CRUD/edit-category.html.twig', [
            'title' => 'Modifier une categorie',
            'editCategory' => $editCategory->createView()
        ]);
    }

    /**
     * @Route("categorie/supprimer/{id}", name="delete-category", methods="GET", requirements={"page"="\d+"})
     * @param int $id
     * @return Response
     */
    public function deleteCategory(int $id): Response {

        $category = $this->getDoctrine()->getRepository(Category::class)->find($id);

        $deleteCategory = $this->getDoctrine()->getManager();
        $deleteCategory->remove($category);
        $deleteCategory->flush();

        $this->addFlash('category', 'La catégorie a bien été supprimé');
        return $this->redirectToRoute('add-category');
    }

    /**
     * @Route("/produits/ajouter", name="add-product", methods="POST|GET")
     * @param Request $request
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
            return $this->redirectToRoute('listes-product');
        }

        return $this->render('back/CRUD/add-product.html.twig', [
            'title' => 'Ajouter un produit a votre boutique',
            'addProduct' => $addProduct->createView()
        ]);
    }

    /**
     * @Route("/produits/modifier/{id}", name="edit-product", methods="GET|POST")
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editProduct(Request $request, int $id): Response {

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $editProduct = $this->createForm(ProductType::class, $product);
        $editProduct->handleRequest($request);

        if($editProduct->isSubmitted() && $editProduct->isValid()) {

            $product = $editProduct->getData();
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $this->addFlash('product', 'Le produit ç bien été modifié');
            return $this->redirectToRoute('show-product', ['id' => $product->getId()]);
        }

        return $this->render('back/CRUD/edit-product.html.twig', [
            'title' => 'Modifier un produit',
            'editProduct' => $editProduct->createView()
        ]);
    }

    /**
     * @Route("/produits/supprimer/{id}", name="delete-product", methods="GET")
     * @param int $id
     * @return Response
     */
    public function deleteProduct(int $id):Response {

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
        $deleteProduct = $this->getDoctrine()->getManager();
        $deleteProduct->remove($product);
        $deleteProduct->flush();
        $this->addFlash('product', 'Le produit à bien été supprimé');
        return $this->redirectToRoute('listes-product');
    }

    /**
     * @Route("/produits/{id}", name="show-product", methods="GET")
     * @param int $id
     * @return Response
     */
    public function showProduct(int $id): Response {

        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);

        return $this->render('back/CRUD/show-product.html.twig', [
            'title' => '',
            'showProduct' => $product
        ]);
    }

    /**
     * @Route("/message-dynamique/ajouter", name="add-random-message-back", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function addRandomMessage(Request $request): Response {

        $message = new RandomMessage();
        $addMessage = $this->createForm(RandomMessageType::class, $message);
        $addMessage->handleRequest($request);

        if($addMessage->isSubmitted() && $addMessage->isValid()) {

            $message = $addMessage->getData();
            $addMessage = $this->getDoctrine()->getManager();
            $addMessage->persist($message);
            $addMessage->flush();

            $this->addFlash('randomMessage', 'Le message à bien été ajouté');
            return $this->redirectToRoute('random-message-back');
        }

        return $this->render('inc/CRUD-message/add-random-message.html.twig', [
            'title' => 'Ajouter un message à diffuser a vos utilisateurs',
            'addMessage' => $addMessage->createView()
        ]);
    }

    /**
     * @Route("/message-dynamique/modifier/{id}", name="edit-random-message", methods="POST|GET")
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function editRandomMessage(Request $request, int $id): Response {

        $message = $this->getDoctrine()->getRepository(RandomMessage::class)->find($id);
        $editMessage = $this->createForm(RandomMessageType::class, $message);
        $editMessage->handleRequest($request);

        if($editMessage->isSubmitted() && $editMessage->isValid()) {

            $message = $editMessage->getData();
            $editMessage = $this->getDoctrine()->getManager();
            $editMessage->flush();
            $this->addFlash('randomMessage', 'Le message à bien été changer');
            return $this->redirectToRoute('random-message-back');
        }

        return $this->render('inc/CRUD-message/edit-random-message.html.twig', [
            'title' => 'Modifier votre message',
            'editMessage' => $editMessage->createView()
        ]);
    }

    /**
     * @Route("/message-dynamique/supprimer/{id}", name="delete-random-message", methods="GET")
     * @param int $id
     * @return Response
     */
    public function deleteRandomMessage(int $id): Response {

        $message = $this->getDoctrine()->getRepository(RandomMessage::class)->find($id);
        $deleteMessage = $this->getDoctrine()->getManager();
        $deleteMessage->remove($message);
        $deleteMessage->flush();
        $this->addFlash('delete', 'Le méssage à bien été supprimé');
        return $this->redirectToRoute('random-message-back');
    }

    /**
     * @Route("/listes-message-dynamique/", name="random-message-back", methods="GET|POST")
     * @param Request $request
     * @return Response
     */
    public function randMessage(Request $request): Response {

        $messageFind = $this->getDoctrine()->getRepository(RandomMessage::class)->findAll();

        $message = new RandomMessage();
        $addMessage = $this->createForm(RandomMessageType::class, $message);
        $addMessage->handleRequest($request);

        if($addMessage->isSubmitted() && $addMessage->isValid()) {

            $message = $addMessage->getData();
            $addMessage = $this->getDoctrine()->getManager();
            $addMessage->persist($message);
            $addMessage->flush();

            $this->addFlash('randomMessage', 'Le message à bien été ajouté');
            return $this->redirectToRoute('random-message-back');
        }

        return $this->render('/inc/CRUD-message/listes-random-message.html.twig', [
            'title' => 'Listes de vos message',
            'showMessage' => $messageFind,
            'addMessage' => $addMessage->createView()
        ]);
    }




}