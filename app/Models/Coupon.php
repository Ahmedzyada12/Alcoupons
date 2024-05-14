<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['title_en', 'title_ar', 'code', 'start_date', 'end_date', 'status', 'featured', 'store_id','flag_code'];

    public function Store(){
        return $this->belongsTo(Store::class);
    }

//    public function scopeSelection($query, $lang)
//    {
//        if(!$lang){
//            $lang = 'en';
//        }
//        $title = 'title_'.$lang;
//        return $query->select('id',$title,'code','store_id','start_date','end_date','status','featured','flag_code',
//            'created_at', 'updated_at');
//
////        return $query->select('id', 'name_'.$lang,'title_'.$lang, 'description_'.$lang,'meta_title_'.$lang);
//    }
}
