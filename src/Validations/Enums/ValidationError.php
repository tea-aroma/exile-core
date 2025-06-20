<?php

namespace TeaAroma\ExileCore\Validations\Enums;


/**
 * Represents an error message for the validation process.
 */
enum ValidationError: string
{
    case NO_VALIDATED = 'The specified {target} has not yet been initialized.';

    case NO_CONTAIN_RULES = 'The specified {target} does not contain any rules.';
}
