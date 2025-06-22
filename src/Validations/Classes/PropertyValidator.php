<?php

namespace TeaAroma\ExileCore\Validations\Classes;


use Illuminate\Support\Collection;
use ReflectionAttribute;
use ReflectionProperty;
use TeaAroma\ExileCore\Formatters\Classes\TemplateParametersFormatter;
use TeaAroma\ExileCore\Validations\Abstracts\Validator;
use TeaAroma\ExileCore\Validations\Interfaces\ValidationRuleInterface;


/**
 * Provides the logic for each property validation.
 */
class PropertyValidator extends Validator
{
    /**
     * The messages.
     *
     * @var Collection<string>
     */
    protected Collection $messages;

    /**
     * The reflection property.
     *
     * @var ReflectionProperty
     */
    protected ReflectionProperty $property;

    /**
     * The validator instance.
     *
     * @var ObjectValidator
     */
    protected ObjectValidator $validator;

    /**
     * @param ReflectionProperty $property
     * @param ObjectValidator    $validator
     */
    public function __construct(ReflectionProperty $property, ObjectValidator $validator)
    {
        $this->messages = new Collection();

        $this->property = $property;

        $this->validator = $validator;
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    protected function validateProcessing(): void
    {
        $attributes = $this->getAttributes();

        foreach ($attributes as $attribute)
        {
            $this->attributeProcessing($attribute);
        }
    }

    /**
     * Handles the process of each attribute.
     *
     * @param ReflectionAttribute $attribute
     *
     * @return void
     */
    protected function attributeProcessing(ReflectionAttribute $attribute): void
    {
        /**
         * @var ValidationRuleInterface $instance
         */
        $instance = $attribute->newInstance();

        if (!$instance->validate($this->getValue()))
        {
            $formatter = new TemplateParametersFormatter($instance->message(), [ 'name' => $this->getName(), ...$instance->messageTemplateKeys() ]);

            $this->messages->push($formatter->format());
        }
    }

    /**
     * Returns reflection attributes.
     *
     * @return array<ReflectionAttribute>
     */
    public function getAttributes(): array
    {
        return $this->property->getAttributes();
    }

    /**
     * Returns property name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->property->getName();
    }

    /**
     * Returns property value.
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->property->isInitialized($this->validator->target) ? $this->property->getValue($this->validator->target) : null;
    }

    /**
     * @inheritDoc
     *
     * @return array<string>
     */
    public function messages(): array
    {
        return $this->messages->toArray();
    }
}
