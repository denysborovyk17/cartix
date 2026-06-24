<?php declare(strict_types=1);

namespace App\Actions\Admin\OptionValue;

use App\Repositories\OptionValueRepository;

readonly class DeleteOptionValueAction
{
    public function __construct(
        private OptionValueRepository $optionValueRepository
    ) {
    }

    public function handle(int $optionValueId): void
    {
        $option = $this->optionValueRepository->findById($optionValueId);

        $option->delete();
    }
}
