<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [];

    public function formattedId(): Attribute
    {
        return Attribute::make(
            get: fn () => '#'.Str::of(Str::take(Str::reverse($this->id), 5))->upper()
        )->shouldCache();
    }

    public function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => Number::currency($this->cart->total, 'LKR')
        )->shouldCache();
    }

    public function isFulfilled(): bool
    {
        return $this->fulfillment_status === 'fulfilled';
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'purchase_price', 'subtotal');
    }
}
