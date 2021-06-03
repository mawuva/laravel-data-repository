<?php

namespace Mawuekom\DataRepository;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\DataRepository\Skeleton\SkeletonClass
 */
class DataRepositoryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'data-repository';
    }
}
