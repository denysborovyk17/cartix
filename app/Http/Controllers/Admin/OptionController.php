<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Repositories\OptionRepository;
use App\Actions\Admin\Option\{CreateOptionAction, UpdateOptionAction, DeleteOptionAction};
use App\Http\Requests\Admin\Option\{StoreOptionRequest, UpdateOptionRequest};
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final readonly class OptionController
{
    public function __construct(
        private OptionRepository $optionRepository
    ) {
    }

    public function index(): View
    {
        $options = $this->optionRepository->getAll();

        return view('sbadmin2.tables.options.index', compact('options'));
    }

    public function create(): View
    {
        return view('sbadmin2.tables.options.create');
    }

    public function store(StoreOptionRequest $request, CreateOptionAction $action): RedirectResponse
    {
        $action->handle($request->getData());

        return redirect()->back();
    }


    public function edit(int $optionId): View
    {
        $option = $this->optionRepository->findById($optionId);

        return view('sbadmin2.tables.options.edit', compact('option'));
    }

    public function update(UpdateOptionRequest $request, UpdateOptionAction $action, int $optionId): RedirectResponse
    {
        $action->handle($request->getData(), $optionId);

        return redirect()->back();
    }

    public function destroy(DeleteOptionAction $action, int $optionId): RedirectResponse
    {
        $action->handle($optionId);

        return redirect()->back();
    }
}
