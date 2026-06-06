<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plan_name',
        'plan_price',
        'duration_days',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'plan_price' => 'decimal:2',
            'duration_days' => 'integer',
        ];
    }

    /**
     * Get all payments for this subscription plan.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
