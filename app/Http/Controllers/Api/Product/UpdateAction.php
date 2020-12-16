<?php


namespace App\Http\Controllers\Api\Product;


use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class UpdateAction extends CreateAction
{
    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function edit(Product $product): JsonResponse
    {
        return response()->json(['success' => !!$product, 'product' => $product->only("id", "title", "description", "price", "image")]);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function update(Product $product, Request $request): JsonResponse
    {
        $success = false;

        $this->validateHttpRequest($request);

        DB::transaction(function () use (&$success, $product, $request) {
            $file = $request->file("image");
            $name = !empty($file) ? $file->getClientOriginalName() : $product->image;

            $success = $product->update(
                array_merge($request->all(), [
                    'image'      => $name,
                    'updated_at' => Carbon::now()
                ]));

            if ($file) {
                $success = $file->move($product->createPath(null, null, true), $name);
            }
        });

        return response()->json(["success" => !!$success]);
    }
}
