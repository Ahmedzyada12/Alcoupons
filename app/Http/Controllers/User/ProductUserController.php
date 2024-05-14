<?php

namespace App\Http\Controllers\User;

use App\Base\Responses\apiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductUserController extends Controller
{
    use apiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('store')->orderBy('id', 'desc')->paginate();
        if (count($products) > 0) {
            return $this->success('get all products successfully', ProductResource::collection($products) ,200);
        }
        return $this->fail('There are no data yet',200);
    }
}
