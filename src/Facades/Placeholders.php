<?php

namespace MPesic381\Placeholders\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MPesic381\Placeholders\Skeleton\SkeletonClass
 */
class Placeholders extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'placeholders';
    }
}
