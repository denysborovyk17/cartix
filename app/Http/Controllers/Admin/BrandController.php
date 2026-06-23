<?php declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Brand\{CreateBrandAction, DeleteBrandAction, UpdateBrandAction};
use App\Http\Requests\Admin\{App\Http\Requests\Admin\Brand\StoreBrandRequest,
    App\Http\Requests\Admin\Brand\UpdateBrandRequest};
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

    public function store(\App\Http\Requests\Admin\Brand\StoreBrandRequest $request, CreateBrandAction $action): RedirectResponse
    {
        $action->handle($request->getData());

        return redirect()->back();
    }

    public function edit(int $brandId): View
    {
        $brand = $this->brandRepository->findById($brandId);

        return view('sbadmin2.tables.brands.edit', compact('brand'));
    }

    public function update(\App\Http\Requests\Admin\Brand\UpdateBrandRequest $request, UpdateBrandAction $action, int $brandId): RedirectResponse
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
