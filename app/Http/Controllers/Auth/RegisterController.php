<?php declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\RegisterRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(
        private readonly RegisterRepository $registerRepository
    ) {
    }

    public function __invoke(RegisterRequest $request): RedirectResponse
    {
        $user = $this->registerRepository->register($request->toDTO());

        Auth::login($user);

        return redirect()->route('index');
    }
}
