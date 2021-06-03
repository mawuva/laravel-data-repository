<?php

namespace Mawuekom\DataRepository\Repositories\Contracts;

/**
 * Base repository contract
 * 
 * Interface BaseRepositoryContract
 * 
 * @package Mawuekom\DataRepository\Repositories\Contracts
 */
interface BaseRepositoryContract
{
    /**
     * Get all model's data 
     * 
     * @param array $columns
     * 
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Retrieve the list of data and can add some adjustments to it
     * Like model's relations...
     * 
     * @param string $orderByColumn
     * @param string $orderBy
     * @param array $with
     * @param array $columns
     * 
     * @return mixed
     */
    public function list($orderByColumn, $orderBy = 'desc', $with = [], $columns = ['*']);

    /**
     * Create new data
     * 
     * @param array $data
     * 
     * @return mixed
     */
    public function create(array $data);

    /**
     * Update data by one attribute
     * 
     * @param string $attribute
     * @param string|int $id
     * @param array $data
     * 
     * @return mixed
     */
    public function update(string $attribute, $id, array $data);

    /**
     * Update data by some params
     * 
     * @param array $params
     * @param array $data
     * 
     * @return mixed
     */
    public function updateBy(array $params, array $data);

    /**
     * Delete data by ID
     * 
     * @param int $id
     * 
     * @return mixed
     */
    public function delete($id);

    /**
     * Delete data by some params
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function deleteBy(array $params);

    /**
     * Search data
     * 
     * @param string|int $searchTerm
     * 
     * @return mixed
     */
    public function search($searchTerm);

    /**
     * Find data by ID
     * 
     * @param int $id
     * @param array $columns
     * 
     * @return mixed
     */
    public function find($id, $columns = ['*']);

    /**
     * Find data by some params
     * 
     * @param array $params
     * @param array $columns
     * 
     * @return mixed
     */
    public function findBy(array $params, $columns = ['*']);

    /**
     * Find all data by some params
     * 
     * @param array $params
     * @param array $columns
     * 
     * @return mixed
     */
    public function findAllBy(array $params, $columns = ['*']);

    /**
     * Get data paginated
     * 
     * @param int $perPages
     * 
     * @return mixed
     */
    public function paginate($perPages = 15);
}