<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{Password, Hash, Auth};
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function showResetForm(string $token): View
    {
        return view('auth.reset-password', compact('token'));
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $status = Password::reset(
            $request->validated(), function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();

                Auth::login($user);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('index')->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
