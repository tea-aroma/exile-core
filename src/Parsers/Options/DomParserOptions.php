<?php

namespace TeaAroma\ExileCore\Parsers\Options;


use TeaAroma\ExileCore\Options\Abstracts\Options;


/**
 * Contains main options for DomParser.
 */
class DomParserOptions extends Options
{
    /**
     * @var string|null
     */
    public ?string $url;

    /**
     * @var string|null
     */
    public ?string $html;

    /**
     * @var array
     */
    public array $httpOptions = [];
}
