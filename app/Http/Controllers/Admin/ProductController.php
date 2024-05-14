<?php

namespace App\Http\Controllers\Admin;

use App\Base\Responses\apiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'store_id.exists' => 'The selected store id is not exists in stores',
        ];
        try {
            $validated = $request->validate([
                "title_en" => ["required", "string", "max:255", "min:3", "unique:products,title_en"],
                "title_ar" => ["required", "string", "max:255", "min:3", "unique:products,title_ar"],
                "description_en" => ["required", "string", "min:20"],
                "description_ar" => ["required", "string", "min:20"],
                "link_en" => ["required", "url" ],
                "link_ar" => ["required", "url"],
                "image" => ["required", "file", "image", "mimes:jpeg,png,jpg,gif,svg", "max:2048", "dimensions:min_width=100,min_height=100"],
                "store_id" => ["required", "integer", "exists:stores,id"]
            ], $messages);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return  $this->error('validation errors', ['errors' => $e->errors()] , 422);
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = $request->title_en . '-image.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/images/products/'), $imageName);
            $data['image'] = $imageName;
        }
        $product = Product::create($data);
        return $this->success('Product created successfully', new ProductResource($product), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('store')->find($id);
        if ($product) {
            return $this->success('get product successfully', new ProductResource($product), 200);
        }
        return $this->fail('This product not found', 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'store_id.exists' => 'The selected store id is not exists in stores',
        ];

        $product = Product::find($id);
        if ($product) {

            try {
                $validated = $request->validate([
                    "title_en" => ["required", "string", "max:255", "min:3", "unique:products,title_en,".$id],
                    "title_ar" => ["required", "string", "max:255", "min:3", "unique:products,title_ar,".$id],
                    "description_en" => ["required", "string", "min:20"],
                    "description_ar" => ["required", "string", "min:20"],
                    "link_en" => ["required", "url", "unique:products,link_en,".$id],
                    "link_ar" => ["required", "url", "unique:products,link_ar,".$id],
                    "image" => ["file", "image", "mimes:jpeg,png,jpg,gif,svg", "max:2048", "dimensions:min_width=100,min_height=100"],
                    "store_id" => ["required", "integer", "exists:stores,id"]
                ], $messages);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return  $this->error('validation errors', ['errors' => $e->errors()] , 422);
            }

            $data = $request->except('image');
            if ($request->hasFile('image')) {
                $image = $product->image;
                $path = parse_url($image, PHP_URL_PATH);
                $relativePath = trim($path, '/');
                if (file_exists($relativePath)) {
                    unlink($relativePath);
                }

                $file = $request->file('image');
                $imageName = $request->title_en . '-image.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/images/products/'), $imageName);
                $data['image'] = $imageName;
            }

            $product->update($data);
            return $this->success('Product updated successfully', new ProductResource($product), 201);

        }
        return $this->fail('This product not found', 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $product = Product::find($id);
        if ($product) {
            $path = parse_url($product->image, PHP_URL_PATH);
            $relativePath = trim($path, '/');
            if (file_exists($relativePath)) {
                unlink($relativePath);
            }
            $product->delete();

            return $this->success('Product deleted successfully', [], 201);

        }
        return $this->fail('This product not found', 200);

    }
}
