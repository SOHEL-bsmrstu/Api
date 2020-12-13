<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class DeleteAction extends Controller
{
    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function delete(Product $product)
    {
        try {
            $filePath = $product->createPath($product->image, null, false);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $deleted = $product->delete();
        } catch (Exception $exception) {
            $deleted = false;
        }

        return response()->json(['deleted' => !!$deleted]);
    }
}
