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
     * Validate data.
     *
     * @param array $data
     */
    public function validate($data)
    {

        $rules = [
            'name' => 'required|bail|min:2|max:255',
            'description' => 'bail|max:255',
            'price' => 'numeric',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first(), 400);
        }
    }
}
