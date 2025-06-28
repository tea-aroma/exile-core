<?php

namespace TeaAroma\ExileCore\CacheManagers\Classes;


use BackedEnum;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;
use TeaAroma\ExileCore\CacheManagers\Abstracts\BaseCacheManager;
use TeaAroma\ExileCore\CacheManagers\Interfaces\TaggedCacheInterface;


/**
 * Provides the managing logic for TaggedCache.
 */
readonly class TaggedCacheManager extends BaseCacheManager implements TaggedCacheInterface
{
    /**
     * The cache tags.
     *
     * @var BackedEnum
     */
    protected BackedEnum $tags;

    /**
     * @param BackedEnum      $ttl
     * @param BackedEnum      $tags
     * @param BackedEnum|null $store
     */
    public function __construct(BackedEnum $ttl, BackedEnum $tags, ?BackedEnum $store = null)
    {
        parent::__construct($ttl, $store);

        $this->tags = $tags;
    }

    /**
     * @inheritDoc
     *
     * @return TaggedCache
     */
    protected function repository(): TaggedCache
    {
        return Cache::store($this->store?->value)->tags($this->tags->value);
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function flush(): bool
    {
        return $this->repository()->flush();
    }
}