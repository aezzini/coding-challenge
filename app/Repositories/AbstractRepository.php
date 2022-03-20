<?php

namespace App\Repositories;

class AbstractRepository implements IRepository
{
    /**
     * @var $object
     */
    protected $object;

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
        return $this->object->findOrFail($id);
    }

    /**
     * Store
     *
     * @param $data
     * @return $object
     */
    public function store($data)
    {
        $this->validate($data);
        $object = new $this->object;

        return $object->create($data);
    }

    /**
     * Update
     *
     * @param $data
     * @return $object
     */
    public function update($data, $id)
    {
        $this->validate($data);
        $object = $this->object->findOrFail($id);

        return $object->update($data);
    }

    /**
     * Update
     *
     * @param $data
     * @return $object
     */
    public function delete($id)
    {
        $object = $this->object->findOrFail($id);
        $object->delete();

        return $object->delete();
    }

    /**
     * DB Data Validation
     *
     * @param array $data
     */
    public function validate($data)
    {
        // Data validation goes here
    }
}
