<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Store
     *
     * @param $data
     * @return $object
     */
    public function store($data)
    {
        $object = new $this->object;

        if (isset($data["image"])) {
            $data["image"] = Storage::put("uploads", $data["image"]);
        }

        if(isset($data["categories"])){
            $categories = $data["categories"];
            unset($data["categories"]);
        }

        /**
         * Fill object properties
         */
        foreach ($data as $key => $value) {
            $object->$key = $value;
        }

        $object->save();
        if(isset($categories)){
            $object->categories()->sync($categories);
        }
        $object->save();

        return $object->fresh();
    }

    /**
     * Update
     *
     * @param $data
     * @return $object
     */
    public function update($data, $id)
    {
        $object = $this->object->find($id);

        if (isset($data["image"])) {
            $data["image"] = Storage::put("uploads", $data["image"]);
            if ($oldImage = $object->image) {
                Storage::delete($oldImage);
            }
        }

        if(isset($data["categories"])){
            $object->categories()->sync($data["categories"]);
            unset($data["categories"]);
        }

        /**
         * Fill object properties
         */
        foreach ($data as $key => $value) {
            $object->$key = $value;
        }

        $object->update();

        return $object;
    }

    /**
     * Update
     *
     * @param $data
     * @return $object
     */
    public function delete($id)
    {
        $object = $this->object->find($id);
        if ($image = $object->image) {
            Storage::delete($image);
        }

        $object->delete();

        return $object;
    }
}
