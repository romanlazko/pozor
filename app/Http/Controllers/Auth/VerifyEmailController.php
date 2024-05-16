<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function emailVerify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }

    public function telegramEmailVerify(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'telegram_chat_id' => 'required|exists:telegram_chats,id',
            'email' => 'required|email|exists:users,email',
        ]);

        if (is_null($user = Password::getUser($request->only('email')))) {
            dd('user not found');
        }

        if (! Password::tokenExists($user, $request->token)) {
            dd('token not found');
        }

        if ($user->markEmailAsVerified()) {
            $user->update([
                'telegram_chat_id' => $request->telegram_chat_id,
            ]);

            Password::deleteToken($user);

            event(new Verified($user));
        }

        return redirect('tg://resolve?domain=pozorbottestbot');
    }
}
