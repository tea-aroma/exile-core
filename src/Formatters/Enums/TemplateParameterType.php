<?php

namespace TeaAroma\ExileCore\Formatters\Enums;


/**
 * Represents a replacement parameter type for templates.
 */
enum TemplateParameterType: string
{
    case DEFAULT = '{%s}';

    case DOUBLE_BRACKET = '{{%s}}';

    /**
     * Returns a template parameter with the specified key.
     *
     * @param string $key
     *
     * @return string
     */
    public function format(string $key): string
    {
        return sprintf($this->value, $key);
    }
}
