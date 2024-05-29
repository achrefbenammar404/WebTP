<?php
namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/add/{id}", name="cart_add")
     */
    public function add($id): Response
    {
        $this->cartService->addToCart($id);
        return $this->redirectToRoute('cart_view');
    }

    /**
     * @Route("/", name="cart_view")
     */
    public function view(): Response
    {
        $cart = $this->cartService->getCart();
        return $this->render('cart/view.html.twig', [
            'cart' => $cart,
        ]);
    }
}
