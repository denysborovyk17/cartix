<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Repositories\OptionRepository;
use App\Actions\Admin\OptionValue\{CreateOptionValueAction, UpdateOptionValueAction, DeleteOptionValueAction};
use App\Http\Requests\Admin\OptionValue\{StoreOptionValueRequest, UpdateOptionValueRequest};
use App\Repositories\OptionValueRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final readonly class OptionValueController
{
    public function __construct(
        private OptionValueRepository $optionValueRepository,
        private OptionRepository $optionRepository
    ) {
    }

    public function index(): View
    {
        $optionValues = $this->optionValueRepository->getAll();

        return view('sbadmin2.tables.option-values.index', compact('optionValues'));
    }

    public function create(): View
    {
        $options = $this->optionRepository->getAllCollection();

        return view('sbadmin2.tables.option-values.create', compact('options'));
    }

    public function store(StoreOptionValueRequest $request, CreateOptionValueAction $action): RedirectResponse
    {
        $action->handle($request->getData());

        return redirect()->back();
    }

    public function edit(int $optionValueId): View
    {
        $options = $this->optionRepository->getAll();
        $optionValue = $this->optionValueRepository->findById($optionValueId);

        return view('sbadmin2.tables.option-values.edit', compact('optionValue', 'options'));
    }

    public function update(UpdateOptionValueRequest $request, UpdateOptionValueAction $action, int $optionValueId): RedirectResponse
    {
        $action->handle($request->getData(), $optionValueId);

        return redirect()->back();
    }

    public function destroy(DeleteOptionValueAction $action, int $optionValueId): RedirectResponse
    {
        $action->handle($optionValueId);

        return redirect()->back();
    }
}
