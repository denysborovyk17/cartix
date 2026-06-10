<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class ProductVariantOutOfStockException extends Exception
{
    public function __construct(protected int $productVariantId)
    {
        $message = "Product Variant with ID $productVariantId is out of stock.";

        parent::__construct($message);
    }
}
