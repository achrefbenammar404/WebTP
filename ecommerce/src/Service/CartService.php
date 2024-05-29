<?php

// src/Service/CartService.php
namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function addToCart($productId)
    {
        $cart = $this->session->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]++;
        } else {
            $cart[$productId] = 1;
        }
        $this->session->set('cart', $cart);
    }

    public function getCart()
    {
        return $this->session->get('cart', []);
    }
}
