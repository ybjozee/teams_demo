<?php

namespace App\Repository;

use App\Entity\Player;
use App\Interfaces\Repository\PlayerRepositoryInterface;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Player>
 *
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository implements PlayerRepositoryInterface {

    public function __construct(ManagerRegistry $registry) {

        parent::__construct($registry, Player::class);
    }

    public function save(Player $entity, bool $flush = false)
    : void {

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getPlayersForPage(int $page)
    : Paginator {

        $queryBuilder = $this->createQueryBuilder('player')->orderBy('player.name', 'ASC');

        return (new Paginator($queryBuilder))->paginate($page);
    }

    public function getPlayer(string $publicId)
    : Player {

        return $this->findOneBy(['publicId' => $publicId]);
    }

    public function getAllPlayers()
    : array {

        return $this->findBy([], ['name' => 'ASC']);
    }

    public function remove(Player $entity, bool $flush = false)
    : void {

        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
