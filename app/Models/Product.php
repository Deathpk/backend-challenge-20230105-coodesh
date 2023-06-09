<?php

namespace App\Models;

use App\Enums\Product\Status;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [
        'imported_t' => 'datetime:Y-m-d H:i:s',
        'updated_t' => 'datetime:Y-m-d H:i:s',
    ];

    /**
    * The "booted" method of the model.
    */
    protected static function booted(): void
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', '!=', Status::TRASH);
        });
    }

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
        $this->code = $product->code;
        $this->status = Status::PUBLISHED;
        $this->imported_t = Carbon::now();
        $this->updated_t = Carbon::now();
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

    public function updateFromCollection(Collection $attributes): void
    {
        $this->status = $attributes->get('status') ?? $this->status;
        $this->updated_t = Carbon::now();
        $this->url = $attributes->get('url') ?? $this->url;
        $this->product_name = $attributes->get('name') ?? $this->product_name;
        $this->brands = $attributes->get('brands') ?? $this->brands;
        $this->categories = $attributes->get('categories') ?? $this->categories;
        $this->main_category = $attributes->get('mainCategory') ?? $this->main_category;
        $this->labels = $attributes->get('label') ?? $this->labels;
        $this->traces = $attributes->get('traces') ?? $this->traces;
        $this->image_url = $attributes->get('imageUrl') ?? $this->image_url;
        $this->nutriscore_score = $attributes->get('nutriScore') ?? $this->nutriscore_score;
        $this->nutriscore_grade = $attributes->get('nutriScoreGrade') ?? $this->nutriscore_grade;
        $this->cities = $attributes->get('cities') ?? $this->cities;
        $this->purchase_places = $attributes->get('purchasePlaces') ?? $this->purchase_places;
        $this->stores = $attributes->get('stores') ?? $this->stores;

        $this->save();
    }

    public function inactivate(): void
    {
        $this->status = Status::TRASH;
        $this->save();
    }
}
