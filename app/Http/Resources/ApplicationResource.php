<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\PlanResource;
use App\Enums\ApplicationStatus;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
             'Application Id' => $this->id,
             'customer'=> new CustomerResource($this->customer),   
             'Address'=> $this->full_address,
             'State'=> ApplicationStatus::class,
             'Order Id' => $this->when($this->status === ApplicationStatus::Complete, $this->order_id),
             'Plan'=> new PlanResource($this->plan)        
        ];
    }
}
