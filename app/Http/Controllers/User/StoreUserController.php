<?php

namespace App\Http\Controllers\User;

use App\Base\Responses\apiResponse;
use App\Http\Resources\user\StoreResource;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Store;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreUserController extends Controller
{
    use apiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::with(['coupons','products','categories'])->orderBy('id', 'desc')->paginate();
        if (count($stores) > 0) {
            return $this->success('Get all stores successfully',StoreResource::collection($stores),200);
        }
        return $this->fail('There are no data yet',200);
    }
    public function storeActive()
    {
        $stores = Store::with(['coupons', 'products', 'categories'])
            ->where('status', 'active')  // Simplified, no need for '=' and extra spaces
            ->get();
        if (count($stores) > 0) {
            return $this->success('Get all stores successfully',StoreResource::collection($stores),200);
        }
        return $this->fail('There are no data yet',200);
    }
    public function storeFeatured()
    {
        $stores = Store::with(['coupons', 'products', 'categories'])
            ->where('featured', 'featured')->paginate();  // Simplified, no need for '=' and extra spaces

        if (count($stores) > 0) {
            return $this->success('Get all stores successfully',StoreResource::collection($stores),200);
        }
        return $this->fail('There are no data yet',200);
    }
    public function allStore()
    {
        $stores = Store::with(['coupons', 'products', 'categories'])
            ->where('allstore', 'all-store')->paginate();  // Simplified, no need for '=' and extra spaces

        if (count($stores) > 0) {
            return $this->success('Get all stores successfully',StoreResource::collection($stores),200);
        }
        return $this->fail('There are no data yet',200);
    }
    public function storeBYcoupon($id)
    {
        $store = Store::with('categories','coupons','products')->find($id);
        if ($store) {
            return $this->success('Get store successfully', new StoreResource($store), 200);
        }
        return $this->fail('This store not found', 200);
    }

    public function search($name)
    {

        $stores = Store::with(['coupons', 'products', 'categories'])
            ->where('allstore', 'all-store')
            ->where(function ($query) use ($name) {
                $query->where('name_en', 'like', '%' . $name . '%')
                    ->orWhere('name_ar', 'like', '%' . $name . '%');
            })->get();
        if (count($stores) > 0) {
            return $this->success('Get all stores by search successfully',StoreResource::collection($stores),200);
        }
        return $this->fail('There are no data yet',200);
    }

    public function language(Request $request)
    {
        // Set or get the language preference from session
        return response()->json([
            'message' => 'Arabic',
            'lang' => 'ar'
        ]);

    }
    public function changelang(Request $request)
    {

//        $lang = $request->lang?? 'ar';
        if ($request->lang === 'ar') {
            return response()->json([
                'message' => 'Arabic',
                'lang' => 'ar'
            ]);
        } else {
            return response()->json([
                'message' => 'English',
                'lang' => 'en'
            ]);
        }
    }

}
