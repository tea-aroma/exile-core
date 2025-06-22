<?php

namespace TeaAroma\ExileCore\Formatters\Classes;


use TeaAroma\ExileCore\Formatters\Enums\TemplateParameterType;
use TeaAroma\ExileCore\Formatters\Interfaces\FormatterInterface;


/**
 * Provides the logic for formatting template parameters.
 */
class TemplateParametersFormatter implements FormatterInterface
{
    /**
     * The value to formatting.
     *
     * @var string
     */
    protected string $value;

    /**
     * The parameters.
     *
     * @var array<string, mixed>
     */
    protected array $parameters = [];

    /**
     * The template parameter type.
     *
     * @var TemplateParameterType
     */
    protected TemplateParameterType $parameterType;

    /**
     * @param string                     $value
     * @param array                      $parameters
     * @param TemplateParameterType|null $parameterType
     */
    public function __construct(string $value, array $parameters = [], ?TemplateParameterType $parameterType = null)
    {
        $this->value = $value;

        $this->parameters = $parameters;

        $this->parameterType = $parameterType ?? TemplateParameterType::DEFAULT;
    }

    /**
     * Returns search parameters.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        return array_map(fn (string $key) => $this->parameterType->format($key), array_keys($this->parameters));
    }

    /**
     * Returns replacements.
     *
     * @return array
     */
    protected function getReplacements(): array
    {
        return array_values($this->parameters);
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function format(): string
    {
        return str_replace($this->getParameters(), $this->getReplacements(), $this->value);
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function origin(): string
    {
        return $this->value;
    }
}
