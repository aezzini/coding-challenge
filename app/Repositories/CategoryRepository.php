<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

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

    /**
     * DB Data Validation.
     *
     * @param array $data
     */
    public function validate($data)
    {

        $rules = [
            'parent_category_id' => 'exists:categories,id',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first(), 403);
        }
    }
}
