<?php

namespace App\Repository;

use App\Entity\Team;
use App\Interfaces\Repository\TeamRepositoryInterface;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Team>
 *
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository implements TeamRepositoryInterface {

    public function __construct(ManagerRegistry $registry) {

        parent::__construct($registry, Team::class);
    }

    public function save(Team $entity, bool $flush = false)
    : void {

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Team $entity, bool $flush = false)
    : void {

        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTeamsForPage(int $page)
    : Paginator {

        $queryBuilder = $this->createQueryBuilder('team')->orderBy('team.name', 'ASC');

        return (new Paginator($queryBuilder))->paginate($page);
    }

    public function getTeam(string $publicId)
    : Team {

        return $this->findOneBy(['publicId' => $publicId]);
    }

    /**
     * @return Team[]
     */
    public function getAllTeams()
    : array {

        return $this->findBy([], ['name' => 'ASC']);
    }
}
