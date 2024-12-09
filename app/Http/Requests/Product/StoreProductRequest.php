<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'image_url' => 'nullable|string',
            'brand_id' => 'nullable|exists:brands,id',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'category_id' => $this->categoryId,
            'brand_id' => $this->brandId,
            'image_url' => $this->imageUrl,
        ]);
    }
}
