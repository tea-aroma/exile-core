<?php

namespace TeaAroma\ExileCore\Validations\Interfaces;


/**
 * Defines the contract for a single validation rule.
 */
interface ValidationRuleInterface
{
    /**
     * Executes validate.
     *
     * @param mixed $value
     * @param       ...$args
     *
     * @return bool
     */
    public function validate(mixed $value, ...$args): bool;

    /**
     * The message for this Rule.
     *
     * @return string
     */
    public function message(): string;

    /**
     * Advanced template keys.
     *
     * @return array<string, mixed>
     */
    public function messageTemplateKeys(): array;
}
