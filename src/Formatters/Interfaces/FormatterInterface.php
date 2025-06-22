<?php

namespace TeaAroma\ExileCore\Formatters\Interfaces;


/**
 * Defines the contract for all formatter implementations.
 */
interface FormatterInterface
{
    /**
     * Returns the formatted value.
     *
     * @return string
     */
    public function format(): string;

    /**
     * Returns the original value.
     *
     * @return string
     */
    public function origin(): string;
}
