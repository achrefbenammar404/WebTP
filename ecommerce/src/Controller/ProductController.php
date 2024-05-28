namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="product_list")
     */
    public function list()
    {
        // Logic to list products
    }
    
    /**
     * @Route("/product/{id}", name="product_detail")
     */
    public function detail($id)
    {
        // Logic to show product details
    }
}
