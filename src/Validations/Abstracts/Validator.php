<?php

namespace TeaAroma\ExileCore\Validations\Abstracts;


use TeaAroma\ExileCore\Validations\Interfaces\ValidatorInterface;


/**
 * Provides the abstract logic for Validators.
 */
abstract class Validator implements ValidatorInterface
{
    /**
     * Handles the validation process.
     *
     * @return void
     */
    abstract protected function validateProcessing(): void;

    /**
     * Determines whether the validation was success.
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return empty($this->messages());
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function validate(): bool
    {
        $this->validateProcessing();

        return $this->isValid();
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function fails(): bool
    {
        return !$this->isValid();
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function passes(): bool
    {
        return $this->isValid();
    }
}
