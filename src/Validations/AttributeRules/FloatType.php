<?php

namespace TeaAroma\ExileCore\Validations\AttributeRules;


use Attribute;
use TeaAroma\ExileCore\Validations\Abstracts\PropertyValidationRule;
use TeaAroma\ExileCore\Validations\Enums\ValidationRuleMessage;


/**
 * Specifies that the annotated property must be of float type.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class FloatType extends PropertyValidationRule
{
    /**
     * @inheritDoc
     *
     * @param mixed $value
     * @param       ...$args
     *
     * @return bool
     */
    public function validate(mixed $value, ...$args): bool
    {
        return is_float($value);
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function message(): string
    {
        return ValidationRuleMessage::FLOAT_TYPE->value;
    }
}
