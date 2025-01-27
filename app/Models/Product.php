<?php

namespace App\Models;

use Carbon\CarbonInterface;
use DateTime;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Number;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use HasSlug;
    use HasUlids;
    use InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'price' => 'float',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => Number::currency($this->price, 'LKR')
        )->shouldCache();
    }

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_product')
            ->withPivot('quantity', 'purchase_price', 'subtotal');
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
}
