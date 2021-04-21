<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Producto
 *
 * @ORM\Table(name="productos", indexes={@ORM\Index(name="fk_producto_categoria", columns={"categoria_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ProductoRepository")
 */
class Producto
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z]+/")
     * @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "El nombre del producto debe tener minimo 3 letras",
     *      maxMessage = "El nombre del producto no puede tener mas de 20 letras"
     * )
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="descripcion", type="text", length=65535, nullable=true)
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z]+/")
     * @Assert\Length(
     *      min = 20,
     *      max = 300,
     *      minMessage = "La descripcion debe tener minimo 20 letras",
     *      maxMessage = "La descripcion no puede tener mas de 300 letras"
     * )
     */
    private $descripcion;

    /**
     * @var float
     *
     * @ORM\Column(name="precio", type="float", precision=100, scale=2, nullable=false)
     * @Assert\NotBlank
     * @Assert\Regex("/[1-9]+/")
     */
    private $precio;

    /**
     * @var int
     *
     * @ORM\Column(name="stock", type="integer", nullable=false)
     * @Assert\NotBlank
     * @Assert\Regex("/[1-9]+/")
     *

     */
    private $stock;

    /**
     * @var string|null
     *
     * @ORM\Column(name="oferta", type="string", length=2, nullable=true)

     */
    private $oferta;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=false)
     */
    private $fecha;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @var \Categoria
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Categoria")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * })
     */
    private $categoria;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineaPedido", mappedBy="producto")
     */

    private $lineasPedidos;

    public function __construct(){
        $this->lineasPedidos = new ArrayCollection;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getOferta(): ?string
    {
        return $this->oferta;
    }

    public function setOferta(?string $oferta): self
    {
        $this->oferta = $oferta;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(?string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

        /**
     * @return Collection|LineaPedido[]
     */
    public function getLineasPedidos(): Collection{
        return $this->lineasPedidos;
    }

    public function addLineasPedido(LineaPedido $lineasPedido): self
    {
        if (!$this->lineasPedidos->contains($lineasPedido)) {
            $this->lineasPedidos[] = $lineasPedido;
            $lineasPedido->setProducto($this);
        }

        return $this;
    }

    public function removeLineasPedido(LineaPedido $lineasPedido): self
    {
        if ($this->lineasPedidos->removeElement($lineasPedido)) {
            // set the owning side to null (unless already changed)
            if ($lineasPedido->getProducto() === $this) {
                $lineasPedido->setProducto(null);
            }
        }

        return $this;
    }


}
