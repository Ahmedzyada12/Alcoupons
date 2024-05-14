<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_ar',
        "meta_title_en", "meta_title_ar", "meta_description_en",
        "meta_description_ar", "meta_keyword_en", "meta_keyword_ar"];

    public function Stores(){
        return $this->belongsToMany(Store::class)->withTimestamps() ;
    }
//    public function scopeSelection($query, $lang)
//    {
//        if ($lang === 'en') {
//            // Prefix 'id' with 'categories.' to specify the table name
//            $query->select('categories.id', 'categories.name_en',"meta_title_en","meta_keyword_en", 'categories.created_at',"meta_description_en", 'categories.updated_at');
//        } else {
//            // Similar adjustment for other languages
//            $query->select('categories.id', 'categories.name_ar',"meta_title_ar","meta_description_ar", "meta_keyword_ar", 'categories.created_at', 'categories.updated_at');
//        }

//        return $query->select('id', 'name_'.$lang,'title_'.$lang, 'description_'.$lang,'meta_title_'.$lang);
//    }
}
