<?php

namespace App\Provider;
use Symfony\Component\HttpFoundation\RequestStack;

class CartProvider {
  private $session;

  public function __construct(private RequestStack $requestStack ) {
      $this->session = $requestStack->getSession();
  }

  public function addCart($id){
      $cart=  $this->session->get('cart',[]);

      if(!empty($cart[$id])){
          $cart[$id]++;
      }else{
          $cart[$id]=1;
      } 

      $this->session->set('cart',$cart);

  }

  public function getCart(){
      return $this->session->get('cart');
  }



}