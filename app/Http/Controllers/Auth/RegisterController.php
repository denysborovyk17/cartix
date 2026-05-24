<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(
        //
    ) {
    }

    public function __invoke(RegisterRequest $request, CreateUserAction $action): RedirectResponse
    {
        $user = $action->handle($request->toDTO());

        Auth::login($user);

        return redirect()->route('index');
    }
}
