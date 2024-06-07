<?php

namespace App\Http\Requests;

use App\Models\Products;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $id = Products::find($this->route('id'));
        return $id && Gate::allows('update-product', $id);
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|integer',
            'unit_price' => 'sometimes|required|decimal:2',
            'amount_sold' => 'sometimes|required|integer',
            'category_name' => 'sometimes|required|string|exists:categories,name'
        ];
    }
}
