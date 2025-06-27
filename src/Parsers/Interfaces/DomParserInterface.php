<?php

namespace TeaAroma\ExileCore\Parsers\Interfaces;


use DOMNodeList;
use JetBrains\PhpStorm\Language;


/**
 * Defines the contract for all dom-parser implementations.
 */
interface DomParserInterface extends ParserInterface
{
    /**
     * Performs the xpath query.
     *
     * @param string $expression
     *
     * @return DOMNodeList|false
     */
    public function xpath(#[Language('XPath')] string $expression): DOMNodeList | false;
}
