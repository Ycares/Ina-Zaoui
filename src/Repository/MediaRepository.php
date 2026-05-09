<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 *
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array<string, mixed> $criteria, array<string, string>|null $orderBy = null, $limit = null, $offset = null)
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    /** @return list<Media> */
    public function findByAlbumExcludingBlockedUsers(Album $album): array
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.user', 'u')
            ->andWhere('m.album = :album')
            ->andWhere('u.blocked = false')
            ->setParameter('album', $album)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

}
