<?php

namespace Mawuekom\DataRepository\Repositories;

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
}