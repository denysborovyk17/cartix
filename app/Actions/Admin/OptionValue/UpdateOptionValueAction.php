<?php declare(strict_types=1);

namespace App\Actions\Admin\OptionValue;

use App\Data\Admin\OptionValueData;
use App\Models\Product\OptionValue;
use App\Repositories\OptionRepository;
use App\Repositories\OptionValueRepository;

readonly class UpdateOptionValueAction
{
    public function __construct(
        private OptionValueRepository $optionValueRepository,
        private OptionRepository $optionRepository
    ) {
    }

    public function handle(OptionValueData $data, int $optionValueId): OptionValue
    {
        $optionValue = $this->optionValueRepository->findById($optionValueId);
        $option = $this->optionRepository->findByName($data->getOptionName());

        $optionValue->update([
            'option_id' => $option->id,
            'value' => $data->getValue()
        ]);

        return $optionValue;
    }
}
