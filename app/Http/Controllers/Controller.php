<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function generateResponse($response = "", $statusCode = 200)
    {
        $result = [
            'status' => 'success',
            'code' => $statusCode,
            'message' => "", //Bad Request
            'data' => []
        ];

        if (!$response) {
            return \Response::json($result, $statusCode);
        }

        if (is_string($response)) {
            $result['message'] = $response;
        } else {
            $result['data'] = json_decode(json_encode($response, true), true);
        }

        if (request()->method() == 'DELETE') {
            $result['code'] = 204;
            return \Response::json($result, 204);
        } else {
            return \Response::json($result, $statusCode);
        }
    }

    protected function generateErrorResponse(\Throwable $exception, $userMessage = false, $inputNamespace = false)
    {
        $response = [
            'status' => 'error',
            'message' => $userMessage ? $userMessage : $exception->getMessage()
        ];
        $statusCode = $exception->getCode() == 0 ? 500 : $exception->getCode();

        $response = array_merge($response, [
            'status' => 'error',
            'code' => $statusCode,
            'message' => $exception->getMessage(),
            'data' => $exception->getFile().". Line : ".$exception->getLine()
        ]);

        if ($inputNamespace === false) {
            if ($exception instanceof InputException) {
                $response['message'] = $exception->getUserMessage()." Fields : ".$exception->getValidatorError();
            }
        } else {
            if ($exception instanceof $inputNamespace . '\InputException') {
                $response['message'] = $exception->getUserMessage()." Fields : ".$exception->getValidatorError();
            }
        }

        return \Response::json($response, $statusCode);
    }
}
