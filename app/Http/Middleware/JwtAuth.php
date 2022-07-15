<?php

namespace App\Http\Middleware;

use App\Exceptions\HttpException;
use App\Services\AuthService;
use Illuminate\Http\Request;

class JwtAuth
{
    public function handle(Request $request,\Closure $next)
    {
        $bearer = $request->header('authorization');

        $split = explode(" ",$bearer);

        if (count($split) !== 2 || $split[0] !== 'Bearer'){
            throw new HttpException(403,"forbidden");
        }

        $token = $split[1];

        $authService = app(AuthService::class);


        try {
            $decode = (array) $authService->decodeJWT($token,config('app.key'));
            $user_id = $decode['user_id'];
            $request->merge([
                "user_id" => $user_id
            ]);
            return $next($request);
        } catch (\Exception $exception) {
            throw new HttpException(403,"forbidden");
        }

    }
}
