<?php

namespace App\Models;

use App\Enums\Product\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [
        'imported_t' => 'datetime:Y-m-d',
        // 'created_t' => 'timestamp:U',
        // 'last_modified_t' => 'timestamp'
    ];

    public static function alreadyExists(string $code): bool
    {
        return self::where('code', $code)->exists();
    }

    public static function create(): self
    {
        return new self();
    }

    public function fromImport(object $product): void
    {
        // dd($product);
        $this->code = $product->code;
        $this->status = Status::PUBLISHED;
        $this->imported_t = Carbon::now();
        $this->url = $product->url;
        $this->creator = $product->creator;
        $this->created_t = Carbon::createFromTimestamp($product->created_t)->toDateTime();
        $this->last_modified_t = Carbon::createFromTimestamp($product->last_modified_t)->toDateTime();
        $this->product_name = $product->product_name;
        $this->quantity = $product->quantity;
        $this->brands = $product->brands;
        $this->categories = $product->categories;
        $this->labels = $product->labels;
        $this->cities = $product->cities;
        $this->purchase_places = $product->purchase_places;
        $this->stores = $product->stores;
        $this->ingredients_text = $product->ingredients_text;
        $this->traces = $product->traces;
        $this->serving_size = $product->serving_size;
        $this->nutriscore_score = $product->nutriscore_score ?? 0;
        $this->nutriscore_grade = $product->nutriscore_grade;
        $this->main_category = $product->main_category;
        $this->image_url = $product->image_url;

        $this->save();
    }
}
