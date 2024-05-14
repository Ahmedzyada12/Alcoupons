<?php

namespace App\Http\Resources\User;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
//use App\Http\Resources\Admin\CategoryResource;

class StoreResource extends JsonResource
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
            "about_ar"=>$this->about_ar,
            "about_en"=>$this->about_en,
            "title_en"=>$this->title_en,
            "title_ar"=>$this->title_ar,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'link_en' => $this->link_en,
            'link_ar' => $this->link_ar,
            'image' => $this->image,
            'status' => $this->status,
            'allstore'=>$this->allstore,
//            'all_store' => $this->all_store,
            'featured' => $this->featured,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'meta'=>[
                'meta_title_en' => $this->meta_title_en,
                'meta_title_ar' => $this->meta_title_ar,
                'meta_description_en' => $this->meta_description_en,
                'meta_description_ar' => $this->meta_description_ar,
                'meta_keyword_en' => $this->meta_keyword_en,
                'meta_keyword_ar' => $this->meta_keyword_ar,
            ],
//            'category_id' => $this->categories->map(function ($category) {
//                return [
//                'id' => $category->id,
//                'name_en' => $category->name_en,
//                'name_ar' => $category->name_ar,
//                  'meta_title_en'=>$category->meta_title_en,
//                  'meta_title_ar'=>$category->meta_title_ar,
//                  'meta_description_en'=>$category->meta_description_en,
//                  'meta_description_ar'=>$category->meta_description_ar,
//                  'meta_keyword_en'=>$category->meta_keyword_en,
//                  'meta_keyword_ar'=>$category->meta_keyword_ar,
//              ];
//            }),
            'category_id'=>$this->categories->pluck('id'),
            'coupons' => CouponResource::collection($this->coupons),
            'products' => ProductResource::collection($this->products),

       ];
    }
}
