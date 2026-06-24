<?php declare(strict_types=1);

namespace App\Actions\Admin\Option;

use App\Repositories\OptionRepository;

readonly class DeleteOptionAction
{
    public function __construct(
        private OptionRepository $optionRepository
    ) {
    }

    public function handle(int $optionId): void
    {
        $option = $this->optionRepository->findById($optionId);

        $option->delete();
    }
}
