<?php

namespace App\Http\Controllers\Admin;

use App\Base\Responses\apiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    use apiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('stores')->orderBy('id', 'desc')->get();
        if (count($categories) > 0) {
            return $this->success('Get All Categories Successfully', CategoryResource::collection($categories)
                , 200);
        }
        return $this->fail('There are no data yet', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                "name_en" => ["required", "string", "max:255", "min:3", "unique:categories,name_en"],
                "name_ar" => ["required", "string", "max:255", "min:3", "unique:categories,name_ar"],
                "meta_title_en" => ["required", "string", "max:255", "min:3"],
                "meta_title_ar" => ["required", "string", "max:255", "min:3"],
                "meta_description_en" => ["required", "string", "min:20"],
                "meta_description_ar" => ["required", "string", "min:20"],
                "meta_keyword_en" => ["required", "string", "min:3"],
                "meta_keyword_ar" => ["required", "string", "min:3"],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return  $this->error('validation errors', ['errors' => $e->errors()] , 422);

        }

        $category = Category::create($request->all());

        return $this->success('Category created successfully', new CategoryResource($category), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::with('stores')->find($id);
        if ($category) {
            return $this->success('Get category successfully', new CategoryResource($category), 200);
        }
        return $this->fail('This category not found', 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if ($category) {
            try {
                $validated = $request->validate([
                    "name_en" => ["required", "string", "max:255", "min:3", Rule::unique("categories", "name_en")->ignore($id)],
                    "name_ar" => ["required", "string", "max:255", "min:3", Rule::unique("categories", "name_ar")->ignore($id)],
                    "meta_title_en" => ["required", "string", "max:255", "min:3"],
                    "meta_title_ar" => ["required", "string", "max:255", "min:3"],
                    "meta_description_en" => ["required", "string", "min:20"],
                    "meta_description_ar" => ["required", "string", "min:20"],
                    "meta_keyword_en" => ["required", "string", "min:3"],
                    "meta_keyword_ar" => ["required", "string", "min:3"],
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return  $this->error('validation errors', ['errors' => $e->errors()] , 422);
            }

            $category->update($request->all());
            return $this->success('Category updated successfully', new CategoryResource($category), 201);
        }
        return $this->fail('This category not found', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return $this->success('Category deleted successfully', [],201);
        }
        return $this->fail('This category not found', 200);
    }
}
