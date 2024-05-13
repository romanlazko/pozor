<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TelegramVerificationRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;

class VerifyTelegramController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(TelegramVerificationRequest $request): RedirectResponse
    {
        $request->user()->update([
            'telegram_chat_id' => $request->telegram_chat_id,
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
