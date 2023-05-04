<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function makeCaptcha(string $typeCaptcha = 'default')
    {
        $captcha = captcha_img($typeCaptcha);
        return response(compact('captcha'));
    }

    public function prepareErrorResponse(array $errorFields)
    {
        return response([
            'errors' => $errorFields
        ], 442);
    }
}
