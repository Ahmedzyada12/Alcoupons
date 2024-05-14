<?php

namespace App\Http\Controllers\Admin;

use App\Base\Responses\apiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'store_id.exists' => 'The selected store id is not exists in stores',
            'start_date.date_format' => 'The start date must be in the format YYYY-MM-DD.',
            'end_date.date_format' => 'The end date must be in the format YYYY-MM-DD.',
        ];
        try {
            $validated = $request->validate([
                "title_en" => ["required"],
                "title_ar" => ["required"],
                "code" => ["required"],
                "start_date" => ["required", "date", "date_format:Y-m-d"],
                "end_date" => ["required", "date", "date_format:Y-m-d"],
                "status" => ["required"],
                "featured" => ["required"],
                "flag_code"=>["required", "string"],
                "store_id" => ["required", "integer", "exists:stores,id"]
            ], $messages);
//            dd($validated);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return  $this->error('validation errors', ['errors' => $e->errors()] , 422);
        }
//        return($validated);exit();
        $coupon = Coupon::create($request->all());

        return $this->success('Coupon created successfully', new CouponResource($coupon), 201);
          //($coupon);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $coupon = Coupon::with('store')->find($id);
        if ($coupon) {
            return $this->success('get coupon successfully', new CouponResource($coupon), 200);

        }
        return $this->fail('This coupon not found', 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'store_id.exists' => 'The selected store id is not exists in stores',
            'start_date.date_format' => 'The start date must be in the format YYYY-MM-DD.',
            'end_date.date_format' => 'The end date must be in the format YYYY-MM-DD.',
        ];

        $coupon = Coupon::find($id);
        if ($coupon) {

            try {
                $validated = $request->validate([
                    "title_en" => ["required", "string", "max:255", "min:3", "unique:coupons,title_en," . $id],
                    "title_ar" => ["required", "string", "max:255", "min:3", "unique:coupons,title_ar," . $id],
                    "code" => ["required", "string", "unique:coupons,code,".$id],
                    "start_date" => ["required", "date", "date_format:Y-m-d"],
                    "end_date" => ["required", "date", "date_format:Y-m-d"],
                    "status" => ["required"],
                    "featured" => ["required"],
                    "flag_code"=>["required", "string"],
                    "store_id" => ["required", "integer", "exists:stores,id"]
                ], $messages);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return  $this->error('validation errors', ['errors' => $e->errors()] , 422);
            }


            $coupon->update($request->all());

            return $this->success('Coupon updated successfully', new CouponResource($coupon), 201);
        }
        return $this->fail('This coupon not found', 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);
        if ($coupon) {
            $coupon->delete();
            return $this->success('Coupon deleted successfully', [], 201);

        }
        return $this->fail('This coupon not found', 200);
    }
}
