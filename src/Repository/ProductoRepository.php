<?php
namespace App\Repository;
 
use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

 
 
class ProductoRepository extends ServiceEntityRepository{
 
    public function __construct(ManagerRegistry $registry)    {
        parent::__construct($registry, Producto::class);
    }
 
    public function findByProducto() {
       return $this->getEntityManager()
                    ->createQuery('
                    SELECT productos.id, productos.nombre, productos.precio, productos.stock, productos.fecha,productos.imagen 
                    From App:Producto productos
                    ')->getResult();

    }

    public function findByPaginator() {
        return $this->getEntityManager()
                     ->createQuery('
                     SELECT productos.id,  productos.nombre, productos.precio, productos.stock,productos.imagen 
                     From App:Producto productos
                     ');
 
     }

}