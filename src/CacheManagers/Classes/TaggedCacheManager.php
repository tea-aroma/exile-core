<?php

namespace TeaAroma\ExileCore\CacheManagers\Classes;


use BackedEnum;
use Closure;
use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;
use TeaAroma\ExileCore\CacheManagers\Interfaces\CacheManagerInterface;


/**
 * Provides the managing logic for TaggedCache.
 */
readonly class TaggedCacheManager implements CacheManagerInterface
{
    /**
     * The cache tags.
     *
     * @var BackedEnum
     */
    public BackedEnum $cacheTags;

    /**
     * The cache ttl.
     *
     * @var BackedEnum
     */
    public BackedEnum $ttl;

    /**
     * @param BackedEnum $cacheTags
     * @param BackedEnum $ttl
     */
    public function __construct(BackedEnum $cacheTags, BackedEnum $ttl)
    {
        $this->cacheTags = $cacheTags;

        $this->ttl = $ttl;
    }

    /**
     * Returns the TaggedCache instance.
     *
     * @return TaggedCache
     */
    protected function builder(): TaggedCache
    {
        return Cache::tags($this->cacheTags->value);
    }

    /**
     * Provides the core cache logic for the 'remember' and 'rememberByForce' methods.
     *
     * @param string  $key
     * @param bool    $shouldSave
     * @param Closure $callback
     *
     * @return mixed
     */
    protected function rememberInternal(string $key, bool $shouldSave, Closure $callback): mixed
    {
        $builder = $this->builder();

        $value = $builder->get($key);

        if (!is_null($value))
        {
            return $value;
        }

        $value = $callback();

        if (is_null($value))
        {
            return null;
        }

        $builder->put($key, $value, $shouldSave ? $this->ttl->value : null);

        return $value;
    }

    /**
     * @inheritDoc
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public function put(string $key, mixed $value): bool
    {
        return $this->builder()->put($key, $value, $this->ttl->value);
    }

    /**
     * @inheritDoc
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->builder()->get($key, $default);
    }

    /**
     * @inheritDoc
     *
     * @param array|string $key
     *
     * @return bool
     */
    public function has(array | string $key): bool
    {
        return $this->builder()->has($key);
    }

    /**
     * @inheritDoc
     *
     * @param string $key
     *
     * @return bool
     */
    public function forget(string $key): bool
    {
        return $this->builder()->forget($key);
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function flush(): bool
    {
        return $this->builder()->flush();
    }

    /**
     * @inheritDoc
     *
     * @param string  $key
     * @param Closure $callback
     *
     * @return mixed
     */
    public function remember(string $key, Closure $callback): mixed
    {
        return $this->rememberInternal($key, true, $callback);
    }

    /**
     * @inheritDoc
     *
     * @param string  $key
     * @param bool    $shouldSave
     * @param Closure $callback
     *
     * @return mixed
     */
    public function rememberByForce(string $key, bool $shouldSave, Closure $callback): mixed
    {
        return $this->rememberInternal($key, $shouldSave, $callback);
    }
}