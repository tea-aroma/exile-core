<?php

namespace TeaAroma\ExileCore\Validations\AttributeRules;


use Attribute;
use TeaAroma\ExileCore\Validations\Abstracts\PropertyValidationRule;
use TeaAroma\ExileCore\Validations\Enums\ValidationRuleMessage;
use TeaAroma\ExileCore\Validations\Enums\ValidationTemplateKey;


/**
 * Specifies that the annotated property must have a minimum value or length.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Min extends PropertyValidationRule
{
    /**
     * @var int
     */
    protected int $min;

    /**
     * @var mixed
     */
    protected mixed $value;

    /**
     * @param int $min
     */
    public function __construct(int $min)
    {
        $this->min = $min;
    }

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
        $this->value = $value;

        if (!$this->isString() && !$this->isInteger())
        {
            return false;
        }

        $value = $this->isString() ? mb_strlen($value) : $value;

        return $value >= $this->min;
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function message(): string
    {
        if ($this->isString())
        {
            return ValidationRuleMessage::MIN_STRING->value;
        }

        return ValidationRuleMessage::MIN_INTEGER->value;
    }

    /**
     * @inheritDoc
     *
     * @return array<string, mixed>
     */
    public function messageTemplateKeys(): array
    {
        return [ ValidationTemplateKey::MIN->value => $this->min ];
    }

    /**
     * @return bool
     */
    public function isString(): bool
    {
        return is_string($this->value);
    }

    /**
     * @return bool
     */
    public function isInteger(): bool
    {
        return is_int($this->value);
    }
}
