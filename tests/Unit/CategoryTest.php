<?php

namespace Tests\Unit;

use App\Http\Controllers\Category as CategoryController;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCategoryController()
    {
        $categoryRepository = new CategoryRepository(new Category());
        $categoryService = new CategoryService($categoryRepository);
        $categoryController = new CategoryController($categoryService);

        /**
         * Test category list
         */
        $request = Request::create('/api/categories', 'GET');
        $response = $categoryController->index($request);
        $this->assertEquals(200, $response->getStatusCode());

        /**
         * Test category create
         */
        $request = Request::create('/api/category/add', 'POST', [
            'name' => 'AYOUB',
        ]);
        $response = $categoryController->store($request);
        $this->assertEquals(200, $response->getStatusCode());

        $id = json_decode($response->getContent(), 1)["data"]["id"];

        /**
         * Test category show
         */
        $request = Request::create('/api/category/show/', 'GET');
        $response = $categoryController->show($id);
        $this->assertEquals(200, $response->getStatusCode());

        /**
         * Test category update
         */
        $request = Request::create('/api/category/update/', 'POST', [
            'name' => 'AYOUB_EDITED',
        ]);
        $response = $categoryController->update($request, $id);
        $this->assertEquals(200, $response->getStatusCode());

        /**
         * Test category delete
         */
        $request = Request::create('/api/category/delete/', 'DELETE');
        $response = $categoryController->destroy($id);
        $this->assertEquals(200, $response->getStatusCode());

    }
}
