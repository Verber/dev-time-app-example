<?php

namespace Verber\DevTime\GalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AlbumRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AlbumRepository extends EntityRepository
{

    public function findAllWithCovers()
    {
        $query = $this->getEntityManager()
            ->createQuery('
            SELECT DISTINCT a, i FROM VerberDevTimeGalleryBundle:Image i
            JOIN i.album a');
        try {
            return $query->getArrayResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return null;
        }
    }
}