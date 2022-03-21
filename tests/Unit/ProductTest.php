<?php

namespace Tests\Unit;

use App\Http\Controllers\Product as ProductController;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testProductController()
    {
        $productRepository = new ProductRepository(new Product());
        $productService = new ProductService($productRepository);
        $productController = new ProductController($productService);

        /**
         * Test product list
         */
        $request = Request::create('/api/products', 'GET');
        $response = $productController->index($request);
        $this->assertEquals(200, $response->getStatusCode());

        /**
         * Test product create
         */
        $request = Request::create('/api/product/add', 'POST', [
            'name' => 'AYOUB',
        ]);
        $response = $productController->store($request);
        $this->assertEquals(200, $response->getStatusCode());

        $id = json_decode($response->getContent(), 1)["data"]["id"];

        /**
         * Test product show
         */
        $request = Request::create('/api/product/show/', 'GET');
        $response = $productController->show($id);
        $this->assertEquals(200, $response->getStatusCode());

        /**
         * Test product update
         */
        $request = Request::create('/api/product/update/', 'POST', [
            'name' => 'AYOUB_EDITED',
        ]);
        $response = $productController->update($request, $id);
        $this->assertEquals(200, $response->getStatusCode());

        /**
         * Test product delete
         */
        $request = Request::create('/api/product/delete/', 'DELETE');
        $response = $productController->destroy($id);
        $this->assertEquals(200, $response->getStatusCode());

    }
}
