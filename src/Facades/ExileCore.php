<?php


use Illuminate\Support\Facades\Facade;


/**
 * @see \Services\ExileCoreService
 */
class ExileCore  extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'exile-core';
    }
}
