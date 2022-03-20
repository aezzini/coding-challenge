<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Validator;
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
            throw new InvalidArgumentException("Unable to update data, invalid parent category.", 400);
        }

        parent::update($data, $id);
    }

    /**
     * Validate data.
     *
     * @param array $data
     */
    public function validate($data)
    {

        $rules = [
            'name' => 'required|bail|min:2|max:255',
            'parent_category_id' => 'numeric',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first(), 400);
        }
    }
}
