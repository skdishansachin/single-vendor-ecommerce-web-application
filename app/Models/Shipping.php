<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory, HasUlids;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_free' => 'boolean',
            'is_active' => 'boolean',
            'conditions' => 'array',
        ];
    }

    public function isApplicable(Cart $cart): bool
    {
        if (empty($this->conditions)) {
            return true;
        }

        foreach ($this->conditions as $condition) {
            switch ($condition['type']) {
                case 'min_total':
                    if ($cart->subtotal < $condition['value']) {
                        return false;
                    }
                    break;
                case 'max_total':
                    if ($cart->subtotal > $condition['value']) {
                        return false;
                    }
                    break;
                case 'min_items':
                    if ($cart->products->sum('pivot.quantity') < $condition['value']) {
                        return false;
                    }
                    break;
                case 'max_items':
                    if ($cart->products->sum('pivot.quantity') > $condition['value']) {
                        return false;
                    }
                    break;
            }
        }

        return true;
    }
}
