<?php

namespace App\Repository;

use App\Entity\Sale;
use App\Interfaces\Repository\SaleRepositoryInterface;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sale>
 *
 * @method Sale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sale[]    findAll()
 * @method Sale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaleRepository extends ServiceEntityRepository implements SaleRepositoryInterface {

    public function __construct(ManagerRegistry $registry) {

        parent::__construct($registry, Sale::class);
    }

    public function save(Sale $entity, bool $flush = false)
    : void {

        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSalesForPage(int $page)
    : Paginator {

        $queryBuilder = $this->createQueryBuilder('sale')->orderBy('sale.amount', 'DESC');

        return (new Paginator($queryBuilder))->paginate($page);
    }

    public function getSale(string $publicId)
    : Sale {

        return $this->findOneBy(['publicId' => $publicId]);
    }

    public function remove(Sale $entity, bool $flush = false)
    : void {

        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
