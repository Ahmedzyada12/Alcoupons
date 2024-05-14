<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title_en', 'title_ar', 'description_en', 'description_ar', 'link_en', 'link_ar', 'image', 'store_id'];


    public function Store(){
        return $this->belongsTo(Store::class);
    }

    public function getImageAttribute($value)
    {
        return asset('uploads/images/products/' . $value);
    }
//    public function scopeSelection($query, $lang)
//    {
//        if(!$lang){
//            $lang = 'en';
//        }
//        $title = 'title_'.$lang;
//        $description = 'description_'.$lang;
//        $link = 'link_'.$lang;
//
//        return $query->select('id',$title,$description,'store_id',$link,'image',
//            'created_at', 'updated_at');
//    }
}
