<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class ProductService extends AbstractService
{

    /**
     * ProductService Constructor
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Update data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return mixed
     */
    public function update($data, $id)
    {
        $validator = Validator::make($data, [
            'name' => 'bail|min:2|max:255',
            'description' => 'bail|max:255',
            'price' => 'numeric',
            'categories' => 'array',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return parent::update($data, $id);
    }

    /**
     * Validate data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return mixed
     */
    public function store($data)
    {
        $rules = [
            'name' => 'bail|min:2|max:255',
            'description' => 'bail|max:255',
            'price' => 'numeric',
            'categories' => 'array',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        return parent::store($data);
    }
}
