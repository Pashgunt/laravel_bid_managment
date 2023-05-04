<?php

namespace App\Http\Controllers;

class CaptchaController extends Controller
{
    public function __invoke()
    {
        return $this->makeCaptcha();
    }
}
