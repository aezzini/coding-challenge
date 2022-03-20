<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends AbstractRepository
{

    /**
     * CategoryRepository Constructor
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->object = $category;
    }
}
