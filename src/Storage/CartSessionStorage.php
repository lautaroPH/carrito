<?php

namespace App\Storage;

use App\Entity\Pedido;
use App\Repository\PedidoRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Class CartSessionStorage
 * @package App\Storage
 */
class CartSessionStorage
{
    /**
     * The session storage.
     *
     * @var SessionInterface
     */
    private $session;

    /**
     * The cart repository.
     *
     * @var PedidoRepository
     */
    private $cartRepository;

    /**
     * @var string
     */
    const CART_KEY_NAME = 'cart_id';

    /**
     * CartSessionStorage constructor.
     *
     * @param SessionInterface $session
     * @param PedidoRepository $cartRepository
     */
    public function __construct(SessionInterface $session, PedidoRepository $cartRepository) 
    {
        $this->session = $session;
        $this->cartRepository = $cartRepository;
    }

    /**
     * Gets the cart in session.
     *
     * @return Pedido|null
     */
    public function getCart(): ?Pedido
    {
        return $this->cartRepository->findOneBy([
            'id' => $this->getCartId(),
            'status' => Pedido::STATUS_CART
        ]);
    }

    /**
     * Sets the cart in session.
     *
     * @param Pedido $cart
     */
    public function setCart(Pedido $cart): void
    {
        $this->session->set(self::CART_KEY_NAME, $cart->getId());
    }

    /**
     * Returns the cart id.
     *
     * @return int|null
     */
    private function getCartId(): ?int
    {
        return $this->session->get(self::CART_KEY_NAME);
    }
}