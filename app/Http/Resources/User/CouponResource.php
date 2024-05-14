<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title_en' => $this->title_en,
            'title_ar' => $this->title_ar,
            'code' => $this->code,
            'featured' => $this->featured,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            "flag_code"=>$this->flag_code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'store' => $this->store
        ];
    }
}
