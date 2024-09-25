<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use App\Form\SearchType;
use App\Filter\Search;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManagerInterface ,private ProductRepository $productRepository)
    {
    }

    #[Route('/nos-produits', name: 'app_product')]
    public function index(Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $products = $this->productRepository->findBySearchFilter($search);
        }
        else {
            $products = $this->entityManagerInterface->getRepository(Product::class)->findAll();
        }
        // Récupère toutes les catégories pour afficher dans le formulaire
        // $categories = $this->entityManagerInterface->getRepository(Category::class)->findAll();
        // dump($categories); // Debugging


        // Récupère tous les produits

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/nos-produits/{slug}', name: 'app_product_item')]
    public function showProduct($slug): Response
    {
        $product = $this->entityManagerInterface->getRepository(Product::class)->findOneBy(['slug' => $slug]);

        return $this->render('product/showProduct.html.twig', [
            'product' => $product,
        ]);
    }
}
