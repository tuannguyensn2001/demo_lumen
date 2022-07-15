<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpException;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @throws HttpException
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {

        $data = $request->only("email", "username", "password");
        $validator = Validator::make($data, [
            'email' => 'email',
            'password' => 'required',
            'username' => 'required'
        ]);


        if ($validator->fails()) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'data not valid');
        }


        $result = $this->authService->register($data);


        return \response()->json([
            "data" => $result
        ]);

    }

    public function login(Request $request)
    {
        $data = $request->only("email", "password");

        $validator = Validator::make($data, [
            "email" => 'email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            throw new HttpException(Response::HTTP_UNPROCESSABLE_ENTITY, 'data not valid');
        }

        $result = $this->authService->login($data['email'], $data['password']);

        return response()->json([
            "data" => $result
        ]);
    }

    public function getMe(Request $request): \Illuminate\Http\JsonResponse
    {

        $user_id = $request['user_id'];
        $result = $this->authService->getMe($user_id);

        return response()->json([
            "data" => $result
        ]);
    }
}
