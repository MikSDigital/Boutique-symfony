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




}