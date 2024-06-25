<?php

namespace App\Repositories;

use App\Models\User;



class UserRepository {

    public function updateOrCreate(array $data, User $user = null){
        if($user){
            $user->update($data);
        }else{
            $user = User::create($data);
        }

        return $user->fresh();
    }
}