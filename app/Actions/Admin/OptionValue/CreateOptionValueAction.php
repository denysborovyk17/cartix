<?php declare(strict_types=1);

namespace App\Actions\Admin\OptionValue;

use App\Data\Admin\OptionValueData;
use App\Models\Product\OptionValue;
use App\Repositories\OptionRepository;

readonly class CreateOptionValueAction
{
    public function __construct(
        private OptionRepository $optionRepository
    ) {
    }

    public function handle(OptionValueData $data): OptionValue
    {
        $option = $this->optionRepository->findByName($data->getOptionName());

        return OptionValue::create([
            'option_id' => $option->id,
            'value' => $data->getValue()
        ]);
    }
}
