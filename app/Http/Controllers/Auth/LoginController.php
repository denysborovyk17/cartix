<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Cart\MergeGuestCartAction;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final readonly class LoginController
{
    public function __invoke(LoginRequest $request, MergeGuestCartAction $action): RedirectResponse
    {
        $credentials = $request->validated();
        $remember = $request->has('remember');

        $sessionId = session()->getId();

        if (Auth::attempt($credentials, $remember)) {
            $action->handle(auth()->id(), $sessionId);

            $request->session()->regenerate();

            return redirect()->route('index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
}
