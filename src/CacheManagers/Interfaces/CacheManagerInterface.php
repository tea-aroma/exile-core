<?php

namespace TeaAroma\ExileCore\CacheManagers\Interfaces;


use Closure;


/**
 * Defines the contract for all cache manager implementations.
 */
interface CacheManagerInterface
{
    /**
     * Saves the specified value by the specified key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return bool
     */
    public function put(string $key, mixed $value): bool;

    /**
     * Returns a cached value by the specified key.
     *
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * Determines whether a cached value exists by the specified key(s).
     *
     * @param array|string $key
     *
     * @return bool
     */
    public function has(array | string $key): bool;

    /**
     * Deletes a cached value by the specified key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function forget(string $key): bool;

    /**
     * Clears all items.
     *
     * @return bool
     */
    public function clear(): bool;

    /**
     * Returns a cached value by the specified key, or execute the given Closure and saves the result.
     *
     * @param string  $key
     * @param Closure $callback
     *
     * @return mixed
     */
    public function remember(string $key, Closure $callback): mixed;

    /**
     * Returns a cached value by key or executes the callback and optionally saves the result.
     *
     * @param string  $key
     * @param bool    $shouldSave
     * @param Closure $callback
     *
     * @return mixed
     */
    public function rememberByForce(string $key, bool $shouldSave, Closure $callback): mixed;
}
