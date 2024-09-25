<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use App\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;

class DeleteImageSubscriber implements EventSubscriberInterface
{

    public function __construct(private Kernel $kernel){

    }

    public function onDeleteImage(BeforeEntityDeletedEvent $event): void
    {
         $entity = $event->getEntityInstance();

         if( ! $entity instanceof Product){
              return ; 
         }
         $image =$this->kernel->getProjectDir().'/public/upload/'.$entity->getImageProduct();
         unlink($image);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityDeletedEvent::class => 'onDeleteImage',
        ];
    }
}
