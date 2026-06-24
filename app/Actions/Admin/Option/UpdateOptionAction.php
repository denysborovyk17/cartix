<?php declare(strict_types=1);

namespace App\Actions\Admin\Option;

use App\Data\Admin\OptionData;
use App\Models\Product\Option;
use App\Repositories\OptionRepository;

readonly class UpdateOptionAction
{
    public function __construct(
        private OptionRepository $optionRepository
    ) {
    }

    public function handle(OptionData $data, int $optionId): Option
    {
        $option = $this->optionRepository->findById($optionId);

        $option->update([
            'name' => $data->getName()
        ]);

        return $option;
    }
}
