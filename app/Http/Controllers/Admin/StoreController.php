<?php

namespace App\Http\Controllers\Admin;

use App\Base\Responses\apiResponse;
use App\Http\Resources\Admin\StoreResource;
use App\Models\Store;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreController extends Controller
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
//            return response()->json($stores, 200);
        }
        return $this->fail('There are no data yet',200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'category_id.exists' => 'The selected category id is not exists in categories', // Custom message for the email uniqueness
        ];
        try {
            $validated = $request->validate([
                "name_en" => ["required", "string", "max:255", "min:3"],
                "name_ar" => ["required", "string", "max:255", "min:3"],
                "title_ar"=> ["required", "string", "max:255", "min:3"],
                "title_en"=> ["required", "string", "max:255", "min:3"],
                "about_ar"=>["required",  "string", "min:20"],
                "about_en"=>["required",  "string", "min:20"],
                "description_en" => ["required", "string", "min:20"],
                "description_ar" => ["required", "string", "min:20"],
                "link_en" => ["required", "url"],
                "link_ar" => ["required", "url"],
                "allstore"=>["required","in:all-store,not-all-store"],
                "image" => ["required", "file", "image", "mimes:jpeg,png,jpg,gif,svg", "max:2048", "dimensions:min_width=100,min_height=100"],
                "status" => ["required", "in:active,in-active"],
                "featured" => ["required", "in:featured,not-featured"],
                "meta_title_en" => ["required", "string", "max:255", "min:3"],
                "meta_title_ar" => ["required", "string", "max:255", "min:3"],
                "meta_description_en" => ["required", "string", "min:20"],
                "meta_description_ar" => ["required", "string", "min:20"],
                "meta_keyword_en" => ["required", "string", "min:3"],
                "meta_keyword_ar" => ["required", "string", "min:3"],
                "category_id" => ["required", "integer", "exists:categories,id"]
            ],$messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return  $this->error('validation errors', ['errors' => $e->errors()] , 422);
        }

        $data = $request->except('image','category_id');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = $request->name_en . '-image.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/images/stores/'), $imageName);
            $data['image'] = $imageName;
        }
        $store = Store::create($data);
        $store->categories()->attach($request->category_id);
        return $this->success('Store created successfully', new StoreResource($store), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $store = Store::with('categories','coupons','products')->find($id);
        if ($store) {
            return $this->success('Get store successfully', new StoreResource($store), 200);
        }
        return $this->fail('This store not found', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'category_id.exists' => 'The selected category id is not exists in categories', // Custom message for the email uniqueness
        ];

        $store = Store::find($id);
        if ($store) {

            try {
                $validated = $request->validate([
                    "name_en" => ["required", "string", "max:255".$id],
                    "name_ar" => ["required", "string", "max:255".$id],
                    "description_en" => ["required", "string", "min:20"],
                    "description_ar" => ["required", "string", "min:20"],
                    "title_ar"=> ["required", "string", "max:255", "min:3"],
                    "title_en"=> ["required", "string", "max:255", "min:3"],
                    "about_ar"=>["required",  "string", "min:20"],
                    "about_en"=>["required",  "string", "min:20"],
                    "link_en" => ["required", "url"],
                    "allstore"=>["required","in:all-store,not-all-store"],
                    "link_ar" => ["required", "url"],
                    "image" => ["file", "image", "mimes:jpeg,png,jpg,gif,svg", "max:2048", "dimensions:min_width=100,min_height=100"],
                    "status" => ["required", "in:active,in-active"],
                    "featured" => ["required", "in:featured,not-featured"],
                    "meta_title_en" => ["required", "string", "max:255".$id],
                    "meta_title_ar" => ["required", "string", "max:255".$id],
                    "meta_description_en" => ["required", "string", "min:20"],
                    "meta_description_ar" => ["required", "string", "min:20"],
                    "meta_keyword_en" => ["required", "string", "min:3"],
                    "meta_keyword_ar" => ["required", "string", "min:3"],
                    "category_id" => ["required", "integer", "exists:categories,id"]

                ],$messages);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return  $this->error('validation errors', ['errors' => $e->errors()] , 422);
            }

            $data = $request->except('image','category_id');
            if ($request->hasFile('image')) {
                $image = $store->image;
                $path = parse_url($image, PHP_URL_PATH);
                $relativePath = trim($path, '/');
                if (file_exists($relativePath)) {
                    unlink($relativePath);
                }
                $file = $request->file('image');
                $imageName = $request->name_en . '-image.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/images/stores/'), $imageName);
                $data['image'] = $imageName;
            }

            $store->update($data);
            $store->categories()->sync($request->category_id);
            return $this->success('Store updated successfully', new StoreResource($store), 201);


        }
        return $this->fail('This store not found', 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $store = Store::find($id);
        if ($store) {
            $path = parse_url($store->image, PHP_URL_PATH);
            $relativePath = trim($path, '/');
            if (file_exists($relativePath)) {
                unlink($relativePath);
            }
            $store->delete();
            $store->categories()->detach();

            return $this->success('Store deleted successfully', [], 201);
        }
        return $this->fail('This store not found', 200);

    }
}
