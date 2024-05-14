<?php

namespace App\Http\Controllers\User;

use App\Base\Responses\apiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponUserController extends Controller
{
    use apiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::with('Store')->orderBy('id', 'desc')->paginate();
        if (count($coupons) > 0) {
            return $this->success('Get All coupons Successfully', CouponResource::collection($coupons)
                , 200);
        }
        return $this->fail('There are no data yet', 200);
    }
    public function couponActive()
    {
        $coupons = Coupon::with('Store')->where('status', '1')->orderBy('id', 'desc')->paginate(); //Coupon Active status
        if (count($coupons) > 0) {
            return $this->success('Get All coupons Successfully', CouponResource::collection($coupons)
                , 200);
        }
        return $this->fail('There are no data yet', 200);
    }
    public function couponFatured()
    {
        $coupons = Coupon::with('Store')->where('featured', '1')->orderBy('id', 'desc')->paginate(); //Coupon Active status
        if (count($coupons) > 0) {
            return $this->success('Get All coupons Successfully', CouponResource::collection($coupons)
                , 200);
        }
        return $this->fail('There are no data yet', 200);
    }



    }
