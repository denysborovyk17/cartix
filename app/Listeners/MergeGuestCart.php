<?php declare(strict_types=1);

namespace App\Listeners;

use App\Actions\Cart\MergeGuestCartAction;
use Illuminate\Auth\Events\Login;

readonly class MergeGuestCart
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private MergeGuestCartAction $action
    ) {
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $this->action->handle(
            $event->user->getAuthIdentifier(),
            request()->cookie(config('session.cookie')) // Old Session ID
        );
    }
}
