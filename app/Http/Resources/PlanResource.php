<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
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
            'Plan Type' => $this->type,
            'Plan Name' => $this->name,
            'Plan monthly cost' => $this->monthly_cost_in_dollars
        ];
    }
}

?>