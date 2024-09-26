<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{  
    private  $sessionInterface;
     public function __construct(private RequestStack $requestStack)
     {
         $this->sessionInterface= $this->requestStack->getSession();
     }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        //  $this->sessionInterface->set('test',[
        //     'id'=>15
        //  ]);
           
        // $this->sessionInterface->remove('test');
       $session = $this->sessionInterface->get('test',[]);
        return $this->render('home/index.html.twig',  ['session'=> $session]);
    }
}
