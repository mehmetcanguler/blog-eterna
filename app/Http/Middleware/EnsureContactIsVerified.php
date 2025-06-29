<?php

namespace App\Http\Middleware;

use App\Enums\LoginType;
use App\Exceptions\EmailNotVerifiedException;
use App\Exceptions\PhoneNotVerifiedException;
use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureContactIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user->login_type === LoginType::EMAIL && ! $request->user()->hasVerifiedEmail()) {
            throw new EmailNotVerifiedException;
        }
        if ($user->login_type === LoginType::PHONE && ! $request->user()->hasVerifiedPhone()) {
            throw new PhoneNotVerifiedException;
        }

        return $next($request);
    }
}
