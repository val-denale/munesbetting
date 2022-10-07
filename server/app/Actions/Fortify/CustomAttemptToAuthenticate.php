<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Fortify;

class CustomAttemptToAuthenticate extends AttemptToAuthenticate
{
    /**
     * Throw a failed authentication validation exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function throwFailedAuthenticationException($request)
    {
        $this->limiter->increment($request);

        throw ValidationException::withMessages([
            Fortify::username() => [trans('auth.failed')],
            'invalidCredentials' => true
        ]);
    }
}
