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
     * Get all.
     *
     * @return $object
     */
    public function getAll($data = [])
    {
        $q = $this->buildQuery($data);
        $q->with("parent");

        if (!isset($data["without_items"])) {
            $qt = clone $q;
            $qt->skip(0)->take(PHP_INT_MAX);

            return ["items" => $q->get(), "total" => $qt->count()];
        } else {
            $qt = clone $q;
            return $qt->skip(0)->take(PHP_INT_MAX)->get();
        }

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
