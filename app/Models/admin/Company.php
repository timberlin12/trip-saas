<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name','user_id','slug','email','logo','phone','address','city','state','country','zip',
        'owner_name','owner_email','owner_mobile','owner_designation',
        'db_host','db_port','db_name','db_username','db_password',
        'domain','plan_id','status'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name) . '-' . Str::random(4);
            }
        });
    }

    // mutator: encrypt db_password before save
    public function setDbPasswordAttribute($value)
    {
        $this->attributes['db_password'] = Crypt::encryptString($value);
    }

    // accessor: decrypt db_password when accessing
    public function getDbPasswordAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    // owner relationship
    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // pricing plan relationship
    public function pricingPlan()
    {
        return $this->belongsTo(PricingPlans::class, 'plan_id');
    }
}
