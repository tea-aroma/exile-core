<?php

namespace TeaAroma\ExileCore\Validations\Enums;


/**
 * Represents a message for the validation rule.
 */
enum ValidationRuleMessage: string
{
    case REQUIRED = 'The {name} is required.';

    case STRING_TYPE = 'The {name} must be a string.';

    case INTEGER_TYPE = 'The {name} must be an integer.';

    case FLOAT_TYPE = 'The {name} must be a float number.';

    case BOOL_TYPE = 'The {name} must be a boolean.';

    case MIN_STRING  = 'The {name} must be at least {min} characters.';

    case MAX_STRING  = 'The {name} must be at most {max} characters.';

    case MIN_INTEGER = 'The {name} must be at least {min}.';

    case MAX_INTEGER = 'The {name} must be at most {max}.';

    case REGEX = 'The {name} must match the pattern {pattern}.';
}
