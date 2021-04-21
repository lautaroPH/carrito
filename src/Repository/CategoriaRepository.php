<?php
namespace App\Repository;
 
use App\Entity\Categoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
 
 
class CategoriaRepository extends ServiceEntityRepository{
 
    public function __construct(ManagerRegistry $registry)    {
        parent::__construct($registry, Categoria::class);
    }
 
    public function findById($order) {
       return $this->getEntityManager()
                    ->createQuery('
                    SELECT categorias.id, categorias.nombre
                    From App:Categoria categorias
                    ')->getResult();

    }
    
}