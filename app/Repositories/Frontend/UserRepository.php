<?php

namespace App\Repositories\Frontend;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserRepository
{
    public function findOrCreate(array $vkData)
    {
        $user = $this->getByVkId($vkData['uid']);

        if ($user) {
            return $user;
        }

        return $this->createByVkData($vkData);
    }

    public function getByVkId($id)
    {
        return User::where('provider_id', $id)->first();
    }

    public function createByVkData($vkData)
    {
        $user = new User();
        $user->provider_id = $vkData['uid'];
        $user->name = $vkData['first_name'] . ' ' . $vkData['last_name'];
        $user->screen_name = $vkData['screen_name'];

        $user->save();

        $user->roles()->attach(Role::getDefaultRole());

        copy($vkData['photo_big'], public_path() . '/img/avatars/users/' . $user->id . '.jpg');

        return $user;
    }
}