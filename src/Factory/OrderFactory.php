<?php

namespace App\Factory;

use App\Entity\Pedido;
use App\Entity\LineaPedido;
use App\Entity\Producto;

/**
 * Class OrderFactory
 * @package App\Factory
 */
class OrderFactory
{
    /**
     * Creates an order.
     *
     * @return Pedido
     */
    public function create(): Pedido
    {
        $pedido = new Pedido();
        $pedido
            ->setStatus(Pedido::STATUS_CART)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime());

        return $pedido;
    }

    /**
     * Creates an item for a product.
     *
     * @param Producto $producto
     *
     * @return LineaPedido
     */
    public function createItem(Producto $producto): LineaPedido
    {
        $item = new LineaPedido();
        $item->setProducto($producto);
        $item->setUnidades(1);

        return $item;
    }
}