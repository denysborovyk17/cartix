<?php declare(strict_types=1);

namespace App\Services;

use Money\Currencies\ISOCurrencies;
use Money\Formatter\{AggregateMoneyFormatter, IntlMoneyFormatter};
use Money\Money;

class MoneyFormatterService
{
    private readonly AggregateMoneyFormatter $aggregateMoneyFormatter;

    public function __construct()
    {
        $numberFormatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $intlFormatter = new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());

        $this->aggregateMoneyFormatter = new AggregateMoneyFormatter([
            'UAH' => $intlFormatter,
            'USD' => $intlFormatter,
            'EUR' => $intlFormatter
        ]);
    }

    public function format(Money $money): string
    {
        return $this->aggregateMoneyFormatter->format($money);
    }
}
