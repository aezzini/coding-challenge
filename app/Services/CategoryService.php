<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use InvalidArgumentException;

class CategoryService extends AbstractService
{

    /**
     * CategoryService Constructor
     *
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->repository = $categoryRepository;
        $this->slug = "category";
    }

    /**
     * Update
     *
     * @param $data
     * @return $object
     */
    public function update($data, $id)
    {
        /**
         * Validate parent category
         */
        if ($id == $data["parent_category_id"]) {
            throw new InvalidArgumentException("Unable to update " . $this->slug . " data, invalid parent category.");
        }

        parent::update($data, $id);
    }
}
