<?php declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Actions\Profile\UpdateProfileAction;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final readonly class ProfileController
{
    public function __construct(
        //
    ) {
    }

    public function index(): View
    {
        return view('profile.index');
    }

    public function update(UpdateProfileRequest $request, UpdateProfileAction $action): RedirectResponse
    {
        $action->handle($request->getData(), auth()->id());

        return redirect()->back();
    }
}
