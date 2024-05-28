// tests/Service/CartServiceTest.php

namespace App\Tests\Service;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CartServiceTest extends KernelTestCase
{
    public function testAddToCart()
    {
        $cartService = self::$container->get(CartService::class);
        $cartService->addToCart(1);

        $this->assertSame([1 => 1], $cartService->getCart());
    }
}
