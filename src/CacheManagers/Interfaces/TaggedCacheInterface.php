<?php

namespace TeaAroma\ExileCore\CacheManagers\Interfaces;


/**
 * Defines the contract for all tagged-cache manager implementations.
 */
interface TaggedCacheInterface extends CacheManagerInterface
{
    /**
     * Removes all items.
     *
     * @return bool
     */
    public function flush(): bool;
}
