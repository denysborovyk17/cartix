<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_variant_id' => $this->product_variant_id,
            'name' => $this->productVariant->product->name,
            'image' => $this->productVariant->product->image,
            'price' => [
                'amount' => $this->productVariant->price,
                'formatted' => '$' . number_format($this->productVariant->price /100, 2),
                'currency' => 'USD'
            ],
            'quantity' => $this->quantity
        ];
    }
}
