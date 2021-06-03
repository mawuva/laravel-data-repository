<?php

namespace Mawuekom\DataRepository\Repositories\Utils;

use Exception;
use Illuminate\Database\Eloquent\Model;

/**
 * Allows to instantiate and deal easily with eloquent model
 * 
 * Trait ModelManager
 * 
 * @package Mawuekom\DataRepository\Repositories\Utils
 */
trait ModelManager
{
    /**
     * Instantiate model
     * 
     * @param Model|string $model
     * 
     * @return Model
     */
    public function makeModel($model)
    {
        $model = app($model);
        
        if (!$model instanceof Model) {
            throw new Exception("Class {$model} must be an instance of Illuminate\Database\Eloquent\Model");
        }

        return $model;
    }
}