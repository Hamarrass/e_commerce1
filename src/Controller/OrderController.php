<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Repository\AddressRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{

    public function __construct(private AddressRepository $ar)
    {
    }


    #[Route('/ma_commande', name: 'app_order')]
    public function index(): Response
    {
        $user = $this->getUser();
        
        $address = $this->ar->getNonDeletedAddressByUserId($user->getId());
        if(empty($address)){
            return $this->redirectToRoute('app_account_address_add');
        }
       $form = $this->createForm(OrderType::class,null,[
           'user' =>$user
       ]);

        return $this->render('order/index.html.twig', [ 
            'form' => $form->createView()
        ]);
    }
}
