<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AccountAddressController extends AbstractController
{
    public function __construct(private EntityManagerInterface $em)
    {
    }


    #[Route('/account/address', name: 'app_account_address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig', []);
    }

    #[Route('/account/address/ajout', name: 'app_account_address_add')]
    public function addAddress(Request $request): Response
    {
        $address = new Address;
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $this->em->persist($address);
            $this->em->flush();
            return $this->redirectToRoute('app_account_address');
        }


        return $this->render('account/add_address.html.twig', [
            'form' => $form->createView()
        ]);
    }


    
        #[Route('/account/address/modifier/{id}', name: 'app_account_address_update')]
        public function updateAddress(Request $request, $id): Response
        {
         
            $address = $this->em->getRepository(Address::class)->findOneById($id);
            $form = $this->createForm(AddressType::class, $address);
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->em->persist($address);
                $this->em->flush();
                return $this->redirectToRoute('app_account_address');
            }
    
    
            return $this->render('account/update_address.html.twig', [
                'form' => $form->createView()
            ]);
        }
    
        #[Route('/account/address/delete/{id}', name: 'app_account_address_delete')]
        public function deleteAddress(Request $request, $id): Response
        {
         
            $address = $this->em->getRepository(Address::class)->findOneById($id);
            $address->setDeleted(true);
            $this->em->persist($address);
            $this->em->flush();
            return $this->redirectToRoute('app_account_address');
    
        }
    
}
