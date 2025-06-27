<?php

namespace TeaAroma\ExileCore\Parsers\Interfaces;


use TeaAroma\ExileCore\Parsers\Data\ParserResult;


/**
 * Defines the contract for all parser implementations.
 */
interface ParserInterface
{
    /**
     * Executes the main parse process.
     *
     * @return void
     */
    public function execute(): void;

    /**
     * Returns the parse result.
     *
     * @return ParserResult
     */
    public function parse(): ParserResult;
}
