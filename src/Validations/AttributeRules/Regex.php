<?php

namespace TeaAroma\ExileCore\Validations\AttributeRules;


use Attribute;
use TeaAroma\ExileCore\Validations\Abstracts\PropertyValidationRule;
use TeaAroma\ExileCore\Validations\Enums\ValidationRuleMessage;
use TeaAroma\ExileCore\Validations\Enums\ValidationTemplateKey;


/**
 * Specifies that the annotated property must match regex.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Regex extends PropertyValidationRule
{
    /**
     * @var string
     */
    private string $pattern;

    /**
     * @param string $pattern
     */
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
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
        if (!is_string($value))
        {
            return false;
        }

        return preg_match($this->pattern, $value) > 0;
    }

    /**
     * @inheritDoc
     *
     * @return string
     */
    public function message(): string
    {
        return ValidationRuleMessage::REGEX->value;
    }

    /**
     * @inheritDoc
     *
     * @return array<string, mixed>
     */
    public function messageTemplateKeys(): array
    {
        return [ ValidationTemplateKey::PATTERN->value => $this->pattern ];
    }
}
