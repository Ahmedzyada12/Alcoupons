<?php

namespace App\Http\Controllers;

use App\Models\lang;
use Illuminate\Http\Request;
use App\Http\Resources\Lang\langResource;
use App\Base\Responses\apiResponse;
class LangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use apiResponse;
    public function index()
    {
        $lang = Lang::latest()->first(); // Retrieve the latest Lang entry
        if ($lang) {
            // Save the Lang object to the session
            session(['current_lang' => $lang]);

            return $this->success('Get Last Lang successfully', $lang->lang, 200);
        } else {
            return $this->fail('There are no data yet', 200);
        }
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                "lang" => ["required", "string", "max:255"],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return  $this->error('validation errors', ['errors' => $e->errors()] , 422);

        }
        $langs = lang::create($request->all());

        return $this->success('Category created successfully', new langResource($langs), 201);
    }



    public function update(Request $request, string $id)
    {
//        $messages = [
//            'store_id.exists' => 'The selected store id does not exist in stores.'
//        ];
//
//        $lang = lang::find($id);
//        if (!$lang) {
//            return $this->fail('This lang was not found.', 404);
//        }
//
//        try {
//            $validated = $request->validate([
//                'lang' => 'string'.$id, // Corrected validation rule
//            ], $messages);
//        } catch (\Illuminate\Validation\ValidationException $e) {
//            return $this->error('Validation errors', ['errors' => $e->errors()], 422);
//        }
//
//        $lang->update($request->all());
//
//        return $this->success('Coupon updated successfully', new langResource($lang), 200);

        $lang = Lang::find($id);
        if ($lang) {
            $lang->update($request->all());
            // Saving updated model to session
            session(['updated_lang' => $lang]);

            return $lang;
        }
    }


}
