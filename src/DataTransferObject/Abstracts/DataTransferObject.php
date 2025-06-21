<?php

namespace TeaAroma\ExileCore\DataTransferObject\Abstracts;


use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;
use ReflectionClass;
use ReflectionProperty;


/**
 * Provides the abstract logic for working with data properties.
 */
abstract class DataTransferObject implements JsonSerializable, Arrayable
{
    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->fill($options);
    }

    /**
     * Returns all properties of the current instance by the specified filter.
     *
     * @param int $filter
     *
     * @return array<ReflectionProperty>
     */
    protected function getProperties(int $filter = ReflectionProperty::IS_PUBLIC): array
    {
        return (new ReflectionClass($this))->getProperties($filter);
    }

    /**
     * Clones the current instance.
     *
     * @return $this
     */
    public function clone(): static
    {
        return clone $this;
    }

    /**
     * Fills the specified options to the current instance.
     *
     * @param array $options
     *
     * @return void
     */
    public function fill(array $options): void
    {
        $properties = $this->getProperties();

        foreach ($properties as $property)
        {
            if (!array_key_exists($property->getName(), $options))
            {
                continue;
            }

            $property->setValue($this, $options[ $property->getName() ]);
        }
    }

    /**
     * Converts the current instance to array.
     *
     * @param bool $withUninitialized
     *
     * @return array
     */
    public function toArray(bool $withUninitialized = false): array
    {
        $array = [];

        $properties = $this->getProperties();

        foreach ($properties as $property)
        {
            $isInitialized = $property->isInitialized();

            if (!$withUninitialized && !$isInitialized)
            {
                continue;
            }

            $array[ $property->getName() ] = $isInitialized ? $property->getValue($this) : null;
        }

        return $array;
    }

    /**
     * Converts the current instance to the sha512 format string.
     *
     * @param bool $withUninitialized
     *
     * @return string
     */
    public function toSha512(bool $withUninitialized = false): string
    {
        return hash('sha512', $this->toJson($withUninitialized));
    }

    /**
     * Converts this instance to the JSON format.
     *
     * @param bool $withUninitialized
     *
     * @return string
     */
    public function toJson(bool $withUninitialized = false): string
    {
        return json_encode($this->toArray($withUninitialized), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * @inheritDoc
     *
     * @return mixed
     */
    public function jsonSerialize(): array
    {
        return $this->toArray(true);
    }

    /**
     * Creates the instance by the specified array.
     *
     * @param array $options
     *
     * @return static
     */
    public static function fromArray(array $options = []): static
    {
        return new static($options);
    }
}
