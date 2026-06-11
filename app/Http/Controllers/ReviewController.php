<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\CreateReviewAction;
use App\Http\Requests\StoreReviewRequest;
use App\Repositories\ProductRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepository,
    ) {}

    public function show(string $slug): View
    {
        $product = $this->productRepository->findBySlug($slug);

        return view('review', compact('product'));
    }

    public function store(StoreReviewRequest $request, CreateReviewAction $action, string $productSlug): RedirectResponse
    {
        $action->handle($request->toDTO(), $productSlug);

        return redirect()->route('products.show', $productSlug);
    }
}
