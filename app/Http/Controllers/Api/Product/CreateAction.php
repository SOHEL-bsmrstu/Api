<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateAction extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $success = false;
        $this->validateHttpRequest($request);

        DB::transaction(function () use (&$success, $request){
            $file = $request->file("image");
            $name = $file->getClientOriginalName();

           $product = auth()->user()->products()->create(
               array_merge($request->all(),[
               'image' => $name,
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now()
           ]));

            $success = $file->move($product->createPath(null, null, true), $name);
        });

        return response()->json(["success" => !!$success]);
    }

    /**
     * @param Request $request
     * @throws ValidationException
     */
    protected function validateHttpRequest(Request $request)
    {
        $rules = [
            'price'       => 'required|numeric|gt:0',
            'description' => 'required|string|min:15',
            'title'       => 'required|string|min:3|max:255',
            'image'       => 'required|mimes:jpeg,jpg,png,gif|max:10000'
        ];

        if (request()->method() === 'PUT'){
            $rules['image'] = 'nullable|mimes:jpeg,jpg,png,gif|max:10000';
        }

        $this->validate($request, $rules);
    }
}
