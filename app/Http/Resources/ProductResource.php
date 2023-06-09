<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'status' => $this->status,
            'createdAt' => Carbon::parse($this->created_t)->format('d/m/Y H:i:s'),
            'importedAt' => Carbon::parse($this->imported_t)->format('d/m/Y H:i:s'),
            'name' => $this->product_name,
            'imageUrl' => $this->image_url,
            'brands' => $this->brands,
            'categories' => $this->categories,
            'mainCategory' => $this->main_category,
            'ingredients' => $this->ingredients_text,
            'creator' => $this->creator,
            'quantity' => $this->quantity,
            'nutritionScore' => $this->nutriscore_score,
            'nutritionGrade' => $this->nutriscore_grade
        ];
    }
}
