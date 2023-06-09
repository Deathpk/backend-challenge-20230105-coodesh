<?php

namespace App\Http\Requests;

use App\Enums\Product\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => [Rule::in([Status::DRAFT->value, Status::PUBLISHED->value])],
            'url' => [ 'required', 'string'],
            'name' => [ 'required', 'string'],
            'brands' => [ 'required', 'string'],
            'categories' => [ 'required', 'string'],
            'mainCategory' => [ 'required', 'string'],
            'labels' => [ 'required', 'string'],
            'traces' => [ 'required', 'string'],
            'imageUrl' => [ 'required', 'string'],
            'nutriScore' => [ 'required', 'integer'],
            'nutriScoreGrade' => [ 'required', 'string'],
            'cities' => [ 'required', 'string'],
            'purchasePlaces' => [ 'required', 'string'],
            'stores' => [ 'required', 'string'],
        ];
    }

    // public function messages()
    // {
        
    // }

    public function getAttributes(): Collection
    {
        return collect($this->validated());
    }
}
