<?php

namespace App\Services;

use App\Exceptions\HttpException;
use App\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws HttpException
     */
    public function register($data)
    {

        $email = $data['email'];
        $password = $data['password'];
        $username = $data['username'];


        $check = $this->userRepository->findByEmail($email);


        if (!is_null($check)) {
            throw new HttpException(ResponseAlias::HTTP_CONFLICT, 'user existed');
        }

        $password = Hash::make($password);

        return $this->userRepository->create([
            'email' => $email,
            'password' => $password,
            'username' => $username
        ]);
    }

    /**
     * @throws HttpException
     */
    public function login($email, $password)
    {
        $user = $this->userRepository->findByEmail($email);



        if (is_null($user)) {
            throw new HttpException(ResponseAlias::HTTP_BAD_REQUEST, "username or password invalid");
        }

        $check = Hash::check($password, $user->password);
        if (!$check) {
            throw new HttpException(ResponseAlias::HTTP_BAD_REQUEST, "username or password invalid");
        }

        $token = $this->generateJWT([
            "exp" => 10000000000000,
            "user_id" => $user->id
        ], config('app.key'));


        return [
            "access_token" => $token,
            "user" => $user
        ];

    }

    /**
     * @throws HttpException
     */
    public function getMe($user_id)
    {
        $user = $this->userRepository->findById($user_id);
        if (is_null($user)) {
            throw new HttpException(ResponseAlias::HTTP_NOT_FOUND, "user not found");
        }

        return $user;
    }

    public function generateJWT($payload, $key): string
    {
        return JWT::encode($payload, $key, 'HS256');
    }

    public function decodeJWT($payload,$key)
    {
        return JWT::decode($payload,new Key($key,"HS256"));
    }


}
