<?php

namespace TeaAroma\ExileCore\Validations\Abstracts;


use TeaAroma\ExileCore\Validations\Interfaces\ValidationRuleInterface;


/**
 * Provides the abstract logic for property validation rules.
 */
abstract class PropertyValidationRule implements ValidationRuleInterface
{
    /**
     * @inheritDoc.
     *
     * @return array<string, mixed>
     */
    public function messageTemplateKeys(): array
    {
        return [];
    }
}
