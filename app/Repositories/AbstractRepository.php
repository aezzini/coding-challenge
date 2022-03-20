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
    public function getAll($data = [])
    {
        $q = $this->buildQuery($data);
        return $q->get();
    }
    

    /**
     * Get all.
     *
     * @return $object
     */
    public function buildQuery($data = [])
    {
        $limit = 10;
        $page = 1;
        $order = "id";
        $orderDirection = "DESC";
        
        if(isset($data["limit"])){
            $limit = $data["limit"];
        }
        if(isset($data["page"])){
            $page = $data["page"];
        }
        if(isset($data["order"])){
            $order = $data["order"];
            $orderDirection = "ASC";
        }
        if(isset($data["orderDirection"])){
            $orderDirection = $data["orderDirection"];
        }

        $q = $this->object->skip($limit*($page-1))->take($limit)->orderBy($order, $orderDirection);
        return $q;
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
