<?php

namespace App\Http\Requests;

use App\Models\Product;
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
        return array_merge(Product::$rules, [
            'name_en' => 'required|string|unique:products,name->en',
            'name_ar' => 'required|string|unique:products,name->ar',
        ]);
    }

    public function prepareForValidation()
    {
        $this->merge([
            'name' => [
                'en' => $this->name_en,
                'ar' => $this->name_ar,
            ],
            'description' =>[
                'en' => $this->description_en,
                'ar' => $this->description_ar,
            ]
        ]);
    }
}
