<?php

namespace TeaAroma\ExileCore\Validations\Enums;


/**
 * Represents a template key for strings.
 */
enum ValidationTemplateKey: string
{
    case NAME = 'name';

    case MIN =  'min';

    case MAX = 'max';

    case PATTERN = 'pattern';

    case TARGET = 'target';
}
