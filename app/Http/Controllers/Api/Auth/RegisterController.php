<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $success = false;
        $this->isValidRequest($request);

        DB::transaction(function () use (&$success, $request) {
            $success = User::create(array_merge($request->all(), [
                'created_at' => Carbon::now(),
                "updated_at" => Carbon::now()
            ]));
        });

        return response()->json(["success" => !!$success]);
    }

    /**
     * @param Request $request
     * @throws ValidationException
     */
    private function isValidRequest(Request $request)
    {
        $this->validate($request, [
            'name'     => 'required|string|min:2|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6|max:100'
        ]);
    }
}
