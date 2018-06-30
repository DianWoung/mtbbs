<?php
/**
 * Created by PhpStorm.
 * User: mt
 * Date: 2018/6/29
 * Time: 14:44
 */

namespace Tests\Traits;

use App\Models\User;

trait ActingJWTUser
{
    public function JWTActingAs(User $user)
    {
        $token = \Auth::guard('api')->fromUser($user);
        $this->withHeaders(['Authorization' => 'Bearer '.$token]);

        return $this;
    }
}