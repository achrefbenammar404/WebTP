<?php
namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Form\CheckoutFormType;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order")
 */
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
    public function checkout(Request $request, EntityManagerInterface $entityManager): Response
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
     * @Route("/confirmation/{id}", name="order_confirmation")
     */
    public function confirmation($id, EntityManagerInterface $entityManager): Response
    {
        $order = $entityManager->getRepository(Order::class)->find($id);

        return $this->render('order/confirmation.html.twig', [
            'order' => $order,
        ]);
    }
}
