<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends AbstractRepository
{

    /**
     * ProductRepository Constructor
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->object = $product;
    }

    /**
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return mixed
     */
    public function store($data)
    {
        if (isset($data["categories"])) {

            $this->validate($data);
            $categories = $data["categories"];
            unset($data["categories"]);
            $object = parent::store($data);
            $object->categories()->sync($categories);

            return $object->fresh();
        } else {

            return parent::store($data);
        }
    }

    /**
     * Get all.
     *
     * @return $object
     */
    public function getAll()
    {
        return $this->object->with("categories")->get();
    }

    /**
     * Get by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->object->where('id', $id)->with("categories")->get();
    }
}
