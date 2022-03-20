<?php

namespace App\Repositories;

class AbstractRepository implements IRepository
{
    /**
     * @var $object
     */
    protected $object;

    /**
     * AbstractRepository Constructor
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * Get all.
     *
     * @return $object
     */
    public function getAll()
    {
        return $this->object->get();
    }

    /**
     * Get by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->object->where('id', $id)->get();
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

        /**
         * Fill object properties
         */
        foreach ($data as $key => $value) {
            $object->$key = $value;
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
        $object->delete();

        return $object;
    }
}
