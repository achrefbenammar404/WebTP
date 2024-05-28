// ecommerce/src/Controller/Admin/OrderController.php
namespace App\Controller\Admin;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/orders")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/", name="admin_order_list")
     */
    public function list(EntityManagerInterface $entityManager)
    {
        $orders = $entityManager->getRepository(Order::class)->findAll();

        return $this->render('admin/order/list.html.twig', [
            'orders' => $orders,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_order_detail")
     */
    public function detail($id, EntityManagerInterface $entityManager)
    {
        $order = $entityManager->getRepository(Order::class)->find($id);

        return $this->render('admin/order/detail.html.twig', [
            'order' => $order,
        ]);
    }
}
