<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** 
 * Categoria
 *
 * @ORM\Table(name="categorias")
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaRepository")
 */
class Categoria
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
     *      minMessage = "El nombre de la categoria debe tener minimo 3 letras",
     *      maxMessage = "El nombre de la categoria no puede tener mas de 20 letras"
     * )
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Producto", mappedBy="categoria")
     */

    private $productos;

    public function __construct(){
        $this->productos = new ArrayCollection;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
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

            /**
     * @return Collection|Producto[]
     */
    public function getProductos(): Collection{
        return $this->productos;
    }

    public function addProducto(Producto $producto): self
    {
        if (!$this->productos->contains($producto)) {
            $this->productos[] = $producto;
            $producto->setCategoria($this);
        }

        return $this;
    }

    public function removeProducto(Producto $producto): self
    {
        if ($this->productos->removeElement($producto)) {
            // set the owning side to null (unless already changed)
            if ($producto->getCategoria() === $this) {
                $producto->setCategoria(null);
            }
        }

        return $this;
    }

}
