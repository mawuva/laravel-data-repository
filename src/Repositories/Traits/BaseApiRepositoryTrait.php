<?php

namespace Mawuekom\DataRepository\Repositories\Traits;

use Spatie\QueryBuilder\QueryBuilder;

/**
 * Base repository trait
 * 
 * Trait BaseApiRepositoryTrait
 * 
 * @package Mawuekom\DataRepository\Repositories\Traits
 */
trait BaseApiRepositoryTrait
{
    /**
     * Get all resources
     * 
     * @return mixed
     */
    public function getAllResources()
    {
        return $this ->collectionQuery($this ->getModel());
    }

    /**
     * Get all resources paginated
     * 
     * @return mixed
     */
    public function paginateAllResources()
    {
        return $this ->collectionQuery($this ->getModel(), true);
    }

    /**
     * Get all resources by
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function getAllResourcesBy(array $params)
    {
        return $this ->collectionQuery($this ->getModel() ->where($params));
    }

    /**
     * Paginate all resources get by
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function paginateAllResourcesBy(array $params)
    {
        return $this ->collectionQuery($this ->getModel() ->where($params), true);
    }

    /**
     * Get resource
     * 
     * @param string $attribute
     * @param string|int $id
     * 
     * @return mixed
     */
    public function getResource(string $attribute, $id)
    {
        return $this ->resourceQuery(
                            $this ->getModel() 
                                  ->where($attribute, '=', $id)
                        );
    }

    /**
     * Get resource by
     * 
     * @param array $params
     * 
     * @return mixed
     */
    public function getResourceBy(array $params)
    {
        return $this ->resourceQuery($this ->getModel() ->where($params));
    }

    /**
     * Search resource
     * 
     * @param string $searchTerm
     * 
     * @return mixed
     */
    public function searchResources($searchTerm)
    {
        return $this ->collectionQuery(
                            $this ->getModel() 
                                  ->whereLike(
                                      $this ->searchFields(), 
                                      $searchTerm
                                  )
                        );
    }

    /**
     * Paginate searched resources
     * 
     * @param string $searchTerm
     * 
     * @return mixed
     */
    public function paginateSearchResources($searchTerm)
    {
        return $this ->collectionQuery(
                            $this ->getModel() 
                                  ->whereLike(
                                      $this ->searchFields(), 
                                      $searchTerm
                                  ), true
                        );
    }

    /**
     * Make query for collections
     * 
     * @param Model $modelStatement
     * @param boolean $paginate
     * 
     * @return mixed
     */
    private function collectionQuery($modelStatement, $paginate = false)
    {
        $query = QueryBuilder::for($modelStatement)
                    ->allowedFilters($this ->filters())
                    ->allowedSorts($this ->sorts())
                    ->allowedIncludes($this ->collectionRelation());

        if (isset($this ->defaultSort) && $this ->defaultSort != null) {
            $query ->defaultSort($this ->defaultSort);
        }

        if ($paginate == true) {
            return $query ->jsonPaginate() 
                          ->appends(request()->query());
        }

        return $query ->get();
    }

    /**
     * Make query to get single resource
     * 
     * @param Model $modelStatement
     * 
     * @return mixed
     */
    public function resourceQuery($modelStatement)
    {
        return QueryBuilder::for($modelStatement)
                  ->allowedIncludes($this ->resourceRelation())
                  ->first();
    }
}