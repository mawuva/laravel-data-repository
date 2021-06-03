<?php

namespace Mawuekom\DataRepository\Repositories;

use Spatie\QueryBuilder\QueryBuilder;
use Mawuekom\DataRepository\Repositories\BaseRepository;
use Mawuekom\DataRepository\Repositories\Contracts\BaseApiRepositoryContract;

/**
 * Base API repository contract
 * 
 * Abstract Class BaseApiRepository
 * 
 * @package Mawuekom\DataRepository\Repositories
 */
abstract class BaseApiRepository extends BaseRepository implements BaseApiRepositoryContract
{
    /**
     * Columns on which filterig will be done
     * 
     * @return array
     */
    abstract public function filters(): array;

    /**
     * Determine by which property the results collection will be ordered
     * 
     * @return array
     */
    abstract public function sorts(): array;

    /**
     * Determine the relation that will be load on the resulting model
     * 
     * @return array
     */
    abstract public function collectionRelation(): array;

    /**
     * Determine the relation that will be load on the resulting model resource
     * 
     * @return array
     */
    abstract public function resourceRelation(): array;

    /**
     * Define a couple fields that will be fetch to reduce the overall size of your SQL query
     * 
     * @return array
     */
    abstract public function fields(): array;

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