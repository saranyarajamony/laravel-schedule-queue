<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use App\Events\ApplicationCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => ApplicationStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => ApplicationCreated::class,
    ];

    protected $fillable = [
        'status',
        'customer_id',
        'plan_id',
        'address_1',
        'city',
        'state',
        'postcode'       
    ];


    public function getMonthlyCostInDollarsAttribute()
    {
        return '$'.number_format($this->monthly_cost/100, 2, '.', ' ' );
    }

    public function getFullAddressAttribute()
    {
        return $this->address_1. ' '.$this->address_2;
    }

    protected $appends = [
        'monthly_cost_in_dollars',
         'full_address'
    ];
 
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
