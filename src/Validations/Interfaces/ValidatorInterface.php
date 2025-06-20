<?php

namespace TeaAroma\ExileCore\Validations\Interfaces;


/**
 * Defines the basic contract for all validator implementations.
 */
interface ValidatorInterface
{
    /**
     * Executes validation.
     *
     * @return bool
     */
    public function validate(): bool;

    /**
     * Determines whether validation has failed.
     *
     * @return bool
     */
    public function fails(): bool;

    /**
     * Determines whether validation has passed.
     *
     * @return bool
     */
    public function passes(): bool;

    /**
     * Returns an array of validation messages.
     *
     * @return array
     */
    public function messages(): array;
}
