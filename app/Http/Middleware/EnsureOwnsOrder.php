<?php declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\HttpStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

readonly class EnsureOwnsOrder
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $orderId = (int) $request->route()->parameter('orderId');

        if ((int) session('order_id') !== $orderId) {
            abort(HttpStatus::NOT_FOUND->value);
        }

        return $next($request);
    }
}
