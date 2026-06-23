<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\User\{CreateUserAction, UpdateUserAction, DeleteUserAction};
use App\Http\Requests\Admin\{StoreUserRequest, UpdateUserRequest};
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final readonly class UserController
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function index(): View
    {
        $users = $this->userRepository->getUsers();

        return view('sbadmin2.tables.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('sbadmin2.tables.users.create');
    }

    public function store(StoreUserRequest $request, CreateUserAction $action): RedirectResponse
    {
        $action->handle($request->getData());

        return redirect()->back();
    }

    public function edit(int $userId): View
    {
        $user = $this->userRepository->findById($userId);

        return view('sbadmin2.tables.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, UpdateUserAction $action, int $userId): RedirectResponse
    {
        $action->handle($request->getData(), $userId);

        return redirect()->back();
    }

    public function destroy(DeleteUserAction $action, int $userId): RedirectResponse
    {
        $action->handle($userId);

        return redirect()->back();
    }
}
