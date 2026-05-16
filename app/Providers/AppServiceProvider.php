<?php declare(strict_types=1);

namespace App\Providers;

use App\Listeners\MergeGuestCart;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Model::preventLazyLoading(! $this->app->isProduction());

        Event::listen(
            Login::class,
            MergeGuestCart::class
        );
    }
}
