// tests/Controller/ProductControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testProductList()
    {
        $client = static::createClient();
        $client->request('GET', '/products');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Product List');
    }
}
