<?php declare(strict_types=1);

namespace App\Listeners;

use App\Actions\MergeGuestCartAction;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MergeGuestCart
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly MergeGuestCartAction $mergeGuestCartAction
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $this->mergeGuestCartAction->execute(
            $event->user->getAuthIdentifier(),
            request()->cookie(config('session.cookie')) // Old Session ID
        );
    }
}
