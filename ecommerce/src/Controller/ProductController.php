// ecommerce/src/Controller/Admin/ProductController.php
namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="admin_product_list")
     */
    public function list(EntityManagerInterface $entityManager)
    {
        $products = $entityManager->getRepository(Product::class)->findAll();

        return $this->render('admin/product/list.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/new", name="admin_product_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_list');
        }

        return $this->render('admin/product/new.html.twig', [
            'productForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_product_edit")
     */
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_product_list');
        }

        return $this->render('admin/product/edit.html.twig', [
            'productForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_product_delete")
     */
    public function delete(Product $product, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('admin_product_list');
    }
    
    /**
     * @Route("/products", name="product_list")
     */
    public function list(Request $request, EntityManagerInterface $entityManager)
    {
        $search = $request->query->get('search', '');
        $category = $request->query->get('category', '');

        $products = $entityManager->getRepository(Product::class)->findBySearchAndCategory($search, $category);
        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render('product/list.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_detail")
     */
    public function detail($id, EntityManagerInterface $entityManager)
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
