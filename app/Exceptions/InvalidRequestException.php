<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Helpers\ApiResponse;

class InvalidRequestException extends Exception
{
    use ApiResponse;

    public function __construct(string $message = "", int $code = 200)
    {
        parent::__construct($message, $code);
    }

    public function render(Request $request)
    {
        return $this->message($this->message, 'error');
    }
}
