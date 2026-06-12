<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\User\CreateUserAction;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

final readonly class RegisterController
{
    public function __construct(
        //
    ) {
    }

    public function __invoke(RegisterRequest $request, CreateUserAction $action): RedirectResponse
    {
        $user = $action->handle($request->getData());

        Auth::login($user);

        return redirect()->route('index');
    }
}
