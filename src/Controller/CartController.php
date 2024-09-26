<?php

namespace App\Controller;

use App\Provider\CartProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

   public function __construct(private CartProvider $cartProvider)
   {
       
   }

    #[Route('/mon-panier', name: 'app_cart')]
    public function index(): Response
    {
        $cart = $this->cartProvider->getCart();
        return $this->render('cart/index.html.twig', [ 
            "cart" => $cart
         ]);
    }

    #[Route('/cart/add/{id}', name: 'app_add_cart')]
    public function add($id): Response
    {
        $this->cartProvider->addCart($id);
        return $this->redirectToRoute('app_cart');
    }
}
