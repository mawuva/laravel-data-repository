<?php

namespace Mawuekom\DataRepository\Repositories\Contracts;

/**
 * Base API repository contract
 * 
 * Interface BaseApiRepositoryContract
 * 
 * @package Mawuekom\DataRepository\Repositories\Contracts
 */
interface BaseApiRepositoryContract
{
    /**
     * Get all resources
     * 
     * @return mixed
     */
    public function getAllResources();

    /**
     * Get all resources paginated
     * 
     * @return mixed
     */
    public function paginateAllResources();

    /**
     * Get all resources by
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function getAllResourcesBy(array $params);

    /**
     * Paginate all resources get by
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function paginateAllResourcesBy(array $params);

    /**
     * Get resource
     * 
     * @param string $attribute
     * @param string|int $id
     * 
     * @return mixed
     */
    public function getResource(string $attribute, $id);

    /**
     * Get resource by
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function getResourceBy(array $params);

    /**
     * Search resource
     * 
     * @param string $searchTerm
     * 
     * @return mixed
     */
    public function searchResources($searchTerm);

    /**
     * Paginate searched resources
     * 
     * @param string $searchTerm
     * 
     * @return mixed
     */
    public function paginateSearchResources($searchTerm);
}