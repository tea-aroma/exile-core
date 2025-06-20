<?php

namespace TeaAroma\ExileCore\Validations\Classes;


use TeaAroma\ExileCore\Validations\Interfaces\ValidationRuleInterface;


/**
 * Provides the logic for the formatting message.
 */
class MessageFormatter
{
    /**
     * The rule instance.
     *
     * @var ValidationRuleInterface
     */
    protected ValidationRuleInterface $rule;

    /**
     * The message.
     *
     * @var string
     */
    protected string $message;

    /**
     * The parameters.
     *
     * @var array
     */
    protected array $parameters = [];

    /**
     * @param ValidationRuleInterface $rule
     * @param array                   $parameters
     */
    public function __construct(ValidationRuleInterface $rule, array $parameters = [])
    {
        $this->rule = $rule;

        $this->message = $rule->message();

        $this->parameters = array_merge($rule->messageTemplateKeys(), $parameters);
    }

    /**
     * Returns search patterns.
     *
     * @return array
     */
    protected function getPatterns(): array
    {
        return array_map(fn(string $key) => "{{$key}}", array_keys($this->parameters));
    }

    /**
     * Returns replacements.
     *
     * @return array
     */
    protected function getReplacements(): array
    {
        return array_values($this->parameters);
    }

    /**
     * Returns the formatted message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return str_replace($this->getPatterns(), $this->getReplacements(), $this->message);
    }

    /**
     * Returns the origin message.
     *
     * @return string
     */
    public function getOriginalMessage(): string
    {
        return $this->rule->message();
    }
}
