<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Usuario
 *
 * @ORM\Table(name="usuarios", uniqueConstraints={@ORM\UniqueConstraint(name="uq_email", columns={"email"})})
 * @ORM\Entity
 */
class Usuario implements UserInterface
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
     *      minMessage = "Tu nombre debe tener minimo 3 letras",
     *      maxMessage = "Tu nombre no puede tener mas de 20 letras"
     * )
     */
    private $nombre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="apellidos", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z]+/")
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     *      minMessage = "Tu apellido debe tener minimo 3 letras",
     *      maxMessage = "Tu apellido no puede tener mas de 20 letras"
     * )
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Email(
     *      message = "el email '{{ value }}' no es valido"
     * )
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @var string|null
     *
     * @ORM\Column(name="rol", type="string", length=20, nullable=true)
     */
    private $rol;

    /**
     * @var string|null
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Order", mappedBy="usuario")
     */

    private $order;

    public function __construct(){
        $this->pedidos = new ArrayCollection;
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(?string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(?string $rol): self
    {
        $this->rol = $rol;

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

    /**
     * @return Collection|Order[]
     */
    public function getOrder(): Collection{
        return $this->orders;
    }

    public function getUsername(){
        return $this->email;
    }
    public function getSalt(){
        return null;
    }

    public function getRoles(){
        return ['ROLE_USER'];
    }

    public function eraseCredentials(){

    }

    public function addPedido(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUsuario($this);
        }

        return $this;
    }

    public function removePedido(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUsuario() === $this) {
                $order->setUsuario(null);
            }
        }

        return $this;
    }
}
