<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class TwoFactor
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('api')->user();
        if (auth('api')->check() && $user->two_factor_code) {
            if (Carbon::parse($user->two_factor_expires_at)->isPast()) {
                $user->resetTwoFactorCode();
                auth('api')->logout();
                $user->tokens()->delete();
                return response([
                    'errors' => [
                        'two_factor_code' => ['Code has died, pls ask new code']
                    ]
                ], 442);
            }
            if (!$request->is('verify*')) {
                return redirect(route('verify.index'));
            }
        }
        return $next($request);
    }
}
