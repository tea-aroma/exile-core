<?php

namespace TeaAroma\ExileCore\CacheManagers\Classes;


use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use TeaAroma\ExileCore\CacheManagers\Abstracts\BaseCacheManager;


/**
 * Provides the managing logic for Cache.
 */
readonly class CacheManager extends BaseCacheManager
{
    /**
     * @inheritDoc
     *
     * @return Repository
     */
    protected function repository(): Repository
    {
        return Cache::store($this->store?->value);
    }
}
