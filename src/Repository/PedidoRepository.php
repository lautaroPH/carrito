<?php
namespace App\Repository;
 
use App\Entity\Pedido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
 
 
/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PedidoRepository extends ServiceEntityRepository{
 
    public function __construct(ManagerRegistry $registry)    {
        parent::__construct($registry, Pedido::class);
    }

    /**
     * Finds carts that have not been modified since the given date.
     *
     * @param \DateTime $limitDate
     * @param int $limit
     *
     * @return int|mixed|string
     */
    public function findCartsNotModifiedSince(\DateTime $limitDate, int $limit = 10): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.status = :status')
            ->andWhere('p.updatedAt < :date')
            ->setParameter('status', Pedido::STATUS_CART)
            ->setParameter('date', $limitDate)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByP() {
       return $this->getEntityManager()
                    ->createQuery('
                    SELECT *
                    From App:Pedido
                    ')->getResult();

    }
    

    
}
