<?php

namespace App\Http\Controllers\User;

use App\Base\Responses\apiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\CategoryResource;
use App\Models\Category;

class CategoryUserController extends Controller
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
    public function show($id)
    {
        $category = Category::with('stores')->find($id);
        if ($category) {
            return $this->success('Get category successfully', new CategoryResource($category), 200);
        }
        return $this->fail('This category not found', 200);

    }

}

