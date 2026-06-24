<?php declare(strict_types=1);

namespace App\Actions\Admin\Option;

use App\Data\Admin\OptionData;
use App\Models\Product\Option;

readonly class CreateOptionAction
{
    public function __construct(
        //
    ) {
    }

    public function handle(OptionData $data): Option
    {
        return Option::create([
            'name' => $data->getName()
        ]);
    }
}
