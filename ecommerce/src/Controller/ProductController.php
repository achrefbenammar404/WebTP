<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="product_list")
     */
    public function list(Request $request, EntityManagerInterface $entityManager): Response
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
    public function detail($id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
