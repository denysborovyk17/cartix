<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Brand\{CreateBrandAction, UpdateBrandAction, DeleteBrandAction};
use App\Http\Requests\Admin\{StoreBrandRequest, UpdateBrandRequest};
use App\Repositories\BrandRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final readonly class BrandController
{
    public function __construct(
        private BrandRepository $brandRepository
    ) {
    }

    public function index(): View
    {
        $brands = $this->brandRepository->getBrands();

        return view('sbadmin2.tables.brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('sbadmin2.tables.brands.create');
    }

    public function store(StoreBrandRequest $request, CreateBrandAction $action): RedirectResponse
    {
        $action->handle($request->getData());

        return redirect()->back();
    }

    public function edit(int $brandId): View
    {
        $brand = $this->brandRepository->findById($brandId);

        return view('sbadmin2.tables.brands.edit', compact('brand'));
    }

    public function update(UpdateBrandRequest $request, UpdateBrandAction $action, int $brandId): RedirectResponse
    {
        $action->handle($request->getData(), $brandId);

        return redirect()->back();
    }

    public function destroy(DeleteBrandAction $action, int $brandId): RedirectResponse
    {
        $action->handle($brandId);

        return redirect()->back();
    }
}
