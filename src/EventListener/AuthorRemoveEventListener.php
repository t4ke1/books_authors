<?php

namespace App\EventListener;


use App\Entity\Book;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class AuthorRemoveEventListener implements EventSubscriber
{

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {

    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::preRemove,
        ];
    }   public function preRemove(LifecycleEventArgs $args): void
{
    $entity = $args->getObject();


   if ($entity instanceof Book) {
        $authors = $entity->getAuthor();
        foreach ($authors as $author) {
            if ($author->getBookCount() < 1) {
                $this->entityManager->remove($author);
                $this->entityManager->flush();
            }
        }
    }
}
}