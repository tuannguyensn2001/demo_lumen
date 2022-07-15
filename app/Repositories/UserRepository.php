<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create($data)
    {
        return User::create($data);
    }

    public function findByEmail($email)
    {
        return User::where("email",$email)->first();
    }

    public function findById($id)
    {
        return User::find($id);
    }

}
