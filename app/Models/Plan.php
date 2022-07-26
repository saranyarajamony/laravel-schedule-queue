<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'monthly_cost'       
    ];


    public function getMonthlyCostInDollarsAttribute()
    {
        return '$'.number_format($this->monthly_cost/100, 2, '.', ' ' );
    }

 
    public function applications()
    {
        return $this->hasMany(Application::class, 'plan_id');
    }
}
