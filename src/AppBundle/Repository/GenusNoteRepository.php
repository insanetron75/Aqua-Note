<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Genus;
use AppBundle\Entity\GenusNote;
use DateTime;
use Doctrine\ORM\EntityRepository;

class GenusNoteRepository extends EntityRepository
{
    /**
     * @return GenusNote[]
     */
    public function findAllRecentNotesForGenus(Genus $genus): array
    {
        return $this->createQueryBuilder('genus_note')
            ->andWhere('genus_note.genus = :genus')
            ->setParameter('genus', $genus)
            ->andWhere('genus_note.createdAt > :recentDate')
            ->setParameter('recentDate', new DateTime('-3 months'))
            ->getQuery()
            ->execute();
    }
}