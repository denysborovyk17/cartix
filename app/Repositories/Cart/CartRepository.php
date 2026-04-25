<?php declare(strict_types=1);

namespace App\Repositories\Cart;

use App\Models\ProductVariant;

class CartRepository
{
    public function getProductVariant(int $productVariantId): ProductVariant
    {
        return ProductVariant::with('product:id,name,slug,image')->findOrFail($productVariantId);
    }
}
