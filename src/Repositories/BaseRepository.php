<?php

namespace Mawuekom\DataRepository\Repositories;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\DataRepository\Repositories\Contracts\BaseRepositoryContract;
use Mawuekom\DataRepository\Repositories\Traits\BaseRepositoryTrait;
use Mawuekom\DataRepository\Repositories\Utils\ModelManager;

/**
 * Base repository contract
 * 
 * Abstract Class BaseRepository
 * 
 * @package Mawuekom\DataRepository\Repositories
 */
abstract class BaseRepository implements BaseRepositoryContract
{
    use ModelManager, BaseRepositoryTrait;

    /** @var Model */
    private $model;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this ->model = $this ->makeModel($this ->model());
    }

    /**
     * Get the model on which works
     * 
     * @return Model
     */
    abstract public function model();

    /**
     * Determine the columns on which the search will be done
     * 
     * @return array
     */
    abstract public function searchFields(): array;

    /**
     * Model setter
     * 
     * @param Model $model
     * 
     * @return void
     */
    public function setModel(Model $model)
    {
        $this ->model = $model;
    }

    /**
     * Model getter
     * 
     * @return Model
     */
    public function getModel()
    {
        return $this ->model;
    }
}