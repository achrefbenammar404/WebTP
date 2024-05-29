<?php

// ecommerce/src/Controller/Admin/DashboardController.php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="admin_dashboard")
     */
    public function index()
    {
        return $this->render('admin/dashboard/index.html.twig');
    }
}
