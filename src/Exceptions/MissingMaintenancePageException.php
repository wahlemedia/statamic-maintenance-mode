<?php

declare(strict_types=1);

namespace Wahlemedia\MaintenanceMode\Exceptions;

use Exception;

class MissingMaintenancePageException extends Exception
{
    public function __construct($message = 'Maintenance page is missing', $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
