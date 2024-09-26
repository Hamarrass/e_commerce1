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

        $offset = max(0,$request->query->getInt('offset',0));
        $products = $this->productRepository->findBySearchFilter($search,$offset);
    
        // Récupère tous les produits

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            "previous"=>$offset - ProductRepository::ITEMS_PER_PAGE,
            "next" =>min(count($products),$offset+ProductRepository::ITEMS_PER_PAGE)
        ]);
    }

    #[Route('/nos-produits/{id}', name: 'app_product_item')]
    public function showProduct($id): Response
    {
        $product = $this->entityManagerInterface->getRepository(Product::class)->findOneBy(['id' => $id]);
        return $this->render('product/showProduct.html.twig', [
            'product' => $product,
        ]);
    }
}
