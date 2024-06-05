@if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <div class="p-4 bg-red-600 text-white rounded-lg">
        <div class="mb-4 text-sm">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>
    
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif
    
        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
    
                <div>
                    <x-buttons.primary>
                        {{ __('Resend Verification Email') }}
                    </x-buttons.primary>
                </div>
            </form>
        </div>
    </div>
@endif