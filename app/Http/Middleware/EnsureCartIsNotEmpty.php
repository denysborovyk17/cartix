<?php declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\Cart\CurrentCartService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class EnsureCartIsNotEmpty
{
    public function __construct(
        private CurrentCartService $currentCartService
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart = $this->currentCartService->findById();

        if ($cart->items->isEmpty()) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
