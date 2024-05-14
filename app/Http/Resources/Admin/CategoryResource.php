<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'meta_title_en' => $this->meta_title_en,
            'meta_title_ar' => $this->meta_title_ar,
            'meta_description_en' => $this->meta_description_en,
            'meta_description_ar' => $this->meta_description_ar,
            'meta_keyword_en' => $this->meta_keyword_en,
            'meta_keyword_ar' => $this->meta_keyword_ar,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'stores' => StoreResource::collection($this->stores)
        ];
    }
}
