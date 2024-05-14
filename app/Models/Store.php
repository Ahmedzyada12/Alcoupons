<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_ar', 'description_en', 'description_ar',
        'link_en', 'link_ar', 'image', 'status', 'featured',
        "title_ar","title_en","about_en","about_ar","allstore",
        "meta_title_en", "meta_title_ar", "meta_description_en",
        "meta_description_ar", "meta_keyword_en", "meta_keyword_ar"
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getImageAttribute($value)
    {
        return asset('uploads/images/stores/' . $value);
    }
//    public function scopeSelection($query)
//    {
//        return $query->select(); // Customize the columns as needed
//    }
//    public function scopeSelection($query, $lang)
//    {

//        if(!$lang){
//            $lang = 'en';
//        }
//        $name='name_'.$lang;
//        $title = 'title_'.$lang;
//        $description = 'description_'.$lang;
//        $meta_title ='meta_title_'.$lang;
//        $meta_description='meta_description_'.$lang;
//        $meta_keyword='meta_keyword_'.$lang;
//        $link = 'link_'.$lang;
//
//        return $query->select('id', $name,$title, $description,$meta_title,$meta_description,$meta_keyword,$link,'image' , 'created_at', 'updated_at')
//            ->with(['products' => function($query) use ($lang) {
//            $query->selection($lang);;
//        }]);
//        return $query->select('id', 'name_'.$lang,'title_'.$lang, 'description_'.$lang,'meta_title_'.$lang);
//    }
}
