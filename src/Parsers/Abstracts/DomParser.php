<?php

namespace TeaAroma\ExileCore\Parsers\Abstracts;


use DOMDocument;
use DOMNodeList;
use DOMXPath;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\Language;
use TeaAroma\ExileCore\Parsers\Interfaces\DomParserInterface;
use TeaAroma\ExileCore\Parsers\Options\DomParserOptions;


/**
 * Provides the base abstract logic for all DomParsers.
 */
abstract class DomParser implements DomParserInterface
{
    /**
     * The options.
     *
     * @var DomParserOptions
     */
    protected DomParserOptions $options;

    /**
     * The DOM document instance.
     *
     * @var DOMDocument
     */
    protected DOMDocument $document;

    /**
     * The instance for queries using the xpath language.
     *
     * @var DOMXPath
     */
    protected DOMXPath $xpath;

    /**
     * @param DomParserOptions $options
     */
    public function __construct(DomParserOptions $options)
    {
        $this->options = $options;

        $this->document = new DOMDocument();
    }

    /**
     * Performs a request by the option url.
     *
     * @return Response|null
     */
    protected function fetch(): ?Response
    {
        $request = null;

        try
        {
            $request = Http::withOptions($this->options->httpOptions)->get($this->options->url);
        }
        catch (ConnectionException $exception)
        {
            Log::error($exception->getMessage());
        }

        return $request;
    }

    /**
     * Returns content to parse.
     *
     * @return string
     */
    protected function getContent(): string
    {
        $content = empty($this->options->url) ? $this->options->html : ($this->fetch()?->body() ?? '');

        return $content ?? '';
    }

    /**
     * Handles the parse process.
     *
     * @return void
     */
    protected function parseHtml(): void
    {
        $this->document->loadHTML($this->getContent());

        $this->xpath = new DOMXPath($this->document);
    }

    /**
     * @inheritDoc
     *
     * @return void
     */
    public function execute(): void
    {
        libxml_use_internal_errors(true);

        $this->parseHtml();

        libxml_clear_errors();

        libxml_use_internal_errors(false);
    }

    /**
     * @inheritDoc
     *
     * @param string $expression
     *
     * @return DOMNodeList|false
     */
    public function xpath(#[Language( 'XPath' )] string $expression): DOMNodeList | false
    {
        return $this->xpath->query($expression);
    }
}
