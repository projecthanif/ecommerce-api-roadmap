<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Product\ProductCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'products' => $this->whenLoaded('products', function ($products) {
                return new ProductCollection($products);
            }),
        ];
    }
}
