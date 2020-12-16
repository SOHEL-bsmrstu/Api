<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class FetchAction extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fetch(Request $request): JsonResponse
    {
        $products = Product::orderBy("id", "desc")->paginate();

        return response()->json(array(
            "success" => (bool) $products,
            "meta"    => [
                "total"       => $products->total(),
                "first"       => $products->firstItem(),
                "last"        => $products->lastItem(),
                "pageCount"   => $products->lastPage(),
                "currentPage" => $products->currentPage(),
            ],
            "data"    => $products->items(),
        ));
    }

    /**
     * @param Product $product
     * @return BinaryFileResponse|void
     * @throws \Exception
     */
    public function imageLink(Product $product): BinaryFileResponse
    {
        $headers  = ['Content-Type' => 'image/png'];
        $filePath = $product->createPath($product->image, null, false);
        
        # If custom image exists & is readable then return the file else show 404 error page
        return (isset($filePath) && is_readable($filePath) ? new BinaryFileResponse($filePath, 200 , $headers) : abort(Response::HTTP_NOT_FOUND));
    }
}
