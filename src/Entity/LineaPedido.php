<?php

namespace App\Entity;

use App\Repository\LineaPedidoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * LineasPedidos
 *
 * @ORM\Table(name="lineas_pedidos", indexes={@ORM\Index(name="fk_linea_producto", columns={"producto_id"}), @ORM\Index(name="fk_linea_pedido", columns={"pedido_id"})})
 * @ORM\Entity(repositoryClass=LineaPedidoRepository::class)
 */
class LineaPedido
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="unidades", type="integer", nullable=false)
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(1)
     */
    private $unidades;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Pedido", inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $orderRef;

    /**
     * @var \Order
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     * })
     */
    private $order;

    /**
     * @var \Producto
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Producto")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     * })
     */
    private $producto;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderRef(): ?Pedido
    {
        return $this->orderRef;
    }

    public function setOrderRef(?Pedido $orderRef): self
    {
        $this->orderRef = $orderRef;

        return $this;
    }

    public function getUnidades(): ?int
    {
        return $this->unidades;
    }

    public function setUnidades(int $unidades): self
    {
        $this->unidades = $unidades;

        return $this;
    }

    public function getPedido(): ?Pedido
    {
        return $this->pedido;
    }

    public function setPedido(?Pedido $pedido): self
    {
        $this->pedido = $pedido;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    /**
 * Tests if the given item given corresponds to the same order item.
 *
 * @param LineaPedido $item
 *
 * @return bool
 */
public function equals(LineaPedido $item): bool
{
    return $this->getProducto()->getId() === $item->getProducto()->getId();
}

/**
 * Calculates the item total.
 *
 * @return float|int
 */
public function getTotal(): float
{
    return $this->getProducto()->getPrecio() * $this->getUnidades();
}

}
