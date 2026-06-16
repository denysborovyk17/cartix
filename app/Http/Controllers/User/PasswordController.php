<?php declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Actions\Profile\UpdatePasswordAction;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final readonly class PasswordController
{
    public function index(): View
    {
        return view('profile.security');
    }

    public function update(UpdatePasswordRequest $request, UpdatePasswordAction $action): RedirectResponse
    {
        $action->handle($request->getData());

        return redirect()->route('profile');
    }
}
