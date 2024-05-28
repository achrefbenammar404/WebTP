// ecommerce/src/Controller/OrderController.php
namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Form\CheckoutFormType;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkout(Request $request, EntityManagerInterface $entityManager)
    {
        $order = new Order();
        $form = $this->createForm(CheckoutFormType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setUser($this->getUser());
            $order->setOrderDate(new \DateTime());
            $order->setStatus('Pending');
            $entityManager->persist($order);

            $cart = $this->cartService->getCart();
            foreach ($cart as $productId => $quantity) {
                $product = $entityManager->getRepository(Product::class)->find($productId);
                $orderItem = new OrderItem();
                $orderItem->setOrder($order);
                $orderItem->setProduct($product);
                $orderItem->setQuantity($quantity);
                $orderItem->setPrice($product->getPrice());
                $entityManager->persist($orderItem);
            }

            $entityManager->flush();

            // Clear the cart
            $this->cartService->clearCart();

            return $this->redirectToRoute('order_confirmation', ['id' => $order->getId()]);
        }

        return $this->render('order/checkout.html.twig', [
            'checkoutForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/order/confirmation/{id}", name="order_confirmation")
     */
    public function confirmation($id, EntityManagerInterface $entityManager)
    {
        $order = $entityManager->getRepository(Order::class)->find($id);

        return $this->render('order/confirmation.html.twig', [
            'order' => $order,
        ]);
    }
}
// src/Controller/OrderController.php
/**
 * @Route("/orders", name="order_history")
 */
public function history(EntityManagerInterface $entityManager)
{
    $orders = $entityManager->getRepository(Order::class)->findBy(['user' => $this->getUser()]);

    return $this->render('order/history.html.twig', [
        'orders' => $orders,
    ]);
}
