// src/Controller/CartController.php
namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $cartService = $cartService;
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add($id)
    {
        $this->cartService->addToCart($id);

        return $this->redirectToRoute('cart_view');
    }

    /**
     * @Route("/cart", name="cart_view")
     */
    public function view()
    {
        $cart = $this->cartService->getCart();

        return $this->render('cart/view.html.twig', [
            'cart' => $cart,
        ]);
    }
}
