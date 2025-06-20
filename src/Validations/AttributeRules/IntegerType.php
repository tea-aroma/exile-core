<?php

namespace TeaAroma\ExileCore\Validations\AttributeRules;


use Attribute;
use TeaAroma\ExileCore\Validations\Abstracts\PropertyValidationRule;
use TeaAroma\ExileCore\Validations\Enums\ValidationRuleMessage;


/**
 * Specifies that the annotated property must be of integer type.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IntegerType extends PropertyValidationRule
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
        return is_int($value);
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function message(): string
    {
        return ValidationRuleMessage::INTEGER_TYPE->value;
    }
}
