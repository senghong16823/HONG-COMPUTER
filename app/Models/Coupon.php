<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_discount_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'max_discount_amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'usage_limit' => 'integer',
            'used_count' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function isValid(float $subtotal = 0): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        $today = now()->startOfDay();
        if ($this->start_date && $today->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $today->gt($this->end_date)) {
            return false;
        }

        if ($subtotal > 0 && $this->min_order_amount > 0 && $subtotal < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if (! $this->isValid($subtotal)) {
            return 0.0;
        }

        if ($this->type === 'percent' || $this->type === 'percentage') {
            $discount = ($subtotal * $this->value) / 100;
            if ($this->max_discount_amount !== null && $discount > $this->max_discount_amount) {
                $discount = (float) $this->max_discount_amount;
            }

            return round($discount, 2);
        }

        return min((float) $this->value, $subtotal);
    }
}
