<?php

namespace LaravelExportConstants\Exceptions;

use Exception;
use Throwable;

class ExportConstantsJsonException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? 'Invalid JavaScript generated.', $code, $previous);
    }

}
