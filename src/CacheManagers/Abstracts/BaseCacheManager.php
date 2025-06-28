<?php

namespace TeaAroma\ExileCore\CacheManagers\Abstracts;


use BackedEnum;
use Closure;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;
use TeaAroma\ExileCore\CacheManagers\Interfaces\CacheManagerInterface;


/**
 * Provides the base abstract logic for all CacheManagers.
 */
readonly abstract class BaseCacheManager implements CacheManagerInterface
{
    /**
     * The cache ttl.
     *
     * @var BackedEnum
     */
    public BackedEnum $ttl;

    /**
     * The store name.
     *
     * @var BackedEnum|null
     */
    public ?BackedEnum $store;

    /**
     * @param BackedEnum      $ttl
     * @param BackedEnum|null $store
     */
    public function __construct(BackedEnum $ttl, ?BackedEnum $store = null)
    {
        $this->ttl = $ttl;

        $this->store = $store;
    }

    /**
     * Returns the repository.
     *
     * @return Repository
     */
    abstract protected function repository(): Repository;

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
        $value = $this->get($key);

        if (!is_null($value))
        {
            return $value;
        }

        $value = $callback();

        if (is_null($value))
        {
            return null;
        }

        $this->repository()->put($key, $value, $shouldSave ? $this->ttl->value : null);

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
        return $this->repository()->put($key, $value, $this->ttl->value);
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
        try
        {
            return $this->repository()->get($key, $default);
        }
        catch (InvalidArgumentException $exception)
        {
            Log::error($exception->getMessage());

            return $default;
        }
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
        try
        {
            return $this->repository()->has($key);
        }
        catch (InvalidArgumentException $exception)
        {
            Log::error($exception->getMessage());

            return false;
        }
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
        return $this->repository()->forget($key);
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function clear() : bool
    {
        return $this->repository()->clear();
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
