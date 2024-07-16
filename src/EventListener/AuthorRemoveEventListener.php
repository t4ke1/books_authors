<?php

namespace App\EventListener;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PreRemoveEventArgs;

class AuthorRemoveEventListener
{

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function preRemove(PreRemoveEventArgs $event): void
    {
        if (!$event->getObject() instanceof Book) {
            return;
        }
        $authors = $event->getObject()->getAuthor();
        foreach ($authors as $author) {
            if ($author->getBookCount() <= 1) {
                $this->entityManager->remove($author);
            }
        }
    }
}
