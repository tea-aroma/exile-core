<?php

namespace TeaAroma\ExileCore\Validations\Classes;


use Illuminate\Support\Collection;
use ReflectionClass;
use ReflectionProperty;
use TeaAroma\ExileCore\Validations\Abstracts\Validator;


/**
 * Provides the main validation logic based on the attribute system.
 */
class ObjectValidator extends Validator
{
    /**
     * The messages.
     *
     * @var Collection<string, array<string>>
     */
    protected Collection $messages;

    /**
     * The target object.
     *
     * @var object
     */
    readonly public object $target;

    /**
     * @param object $target
     */
    public function __construct(object $target)
    {
        $this->messages = new Collection();

        $this->target = $target;
    }

    /**
     * Returns all public properties from the target object.
     *
     * @return array<ReflectionProperty>
     */
    protected function getProperties(): array
    {
        return ( new ReflectionClass($this->target) )->getProperties(ReflectionProperty::IS_PUBLIC);
    }

    /**
     * Appends the specified messages to the existing list.
     *
     * @param PropertyValidator $validator
     *
     * @return void
     */
    protected function appendPropertyMessages(PropertyValidator $validator): void
    {
        $this->messages->put($validator->getName(), $validator->messages());
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    protected function validateProcessing(): void
    {
        $properties = $this->getProperties();

        foreach ($properties as $property)
        {
            $propertyValidator = new PropertyValidator($property, $this);

            if (!$propertyValidator->validate())
            {
                $this->appendPropertyMessages($propertyValidator);
            }
        }
    }

    /**
     * @inheritDoc
     *
     * @return array<string, array<string>>
     */
    public function messages(): array
    {
        return $this->messages->toArray();
    }
}
