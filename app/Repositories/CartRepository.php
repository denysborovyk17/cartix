<?php declare(strict_types=1);

namespace App\Repositories;

use App\Models\ProductVariant;

class CartRepository
{
    public function getProductVariant(int $productVariantId): ProductVariant
    {
        return ProductVariant::with('product:id,name,image')->findOrFail($productVariantId);
    }
}
