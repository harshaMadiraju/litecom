<?php

namespace App\Helpers;

class Response
{
    const SUCCESS = 200;
    const FORM_VALIDATION_ERROR = 422;
    const RESOURCE_NOT_FOUND = 404;
    const URL_EXPIRED = 410;
    const INTERNAL_SERVER_ERROR = 500;
    const UNAUTHORIZED_ERROR = 401;

    public static function prepareResponse($success = false, $data = [], $message = '', $status = 200, $errors = [])
    {
        return [
            'success' => $success,
            'data'  => $data,
            'message'  => $message,
            'status'  => $status,
            'errors' => $errors,
        ];
    }
}
