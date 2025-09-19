<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PricingPlans extends Authenticatable
{
    use HasFactory;

    protected $table = 'pricing_plans';

    protected $fillable = [
        'plan_name',
        'description',
        'price',
        'billing_cycle',
        'trial_days',
        'max_users',
        'features',
        'is_popular',
        'status',
        'discount_type',
        'discount_value',
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'status' => 'boolean',
    ];
}
