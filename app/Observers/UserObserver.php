<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function saving(User $user)
    {
        // 这样写扩展性更高，只有空的时候才指定默认头像
        if (empty($user->avatar)) {
            $user->avatar = '/statics/TrJS40Ey5k.png';
        }
    }

    public function deleted(User $user)
    {
        \DB::table('topics')->where('user_id', $user->id)->delete();
        \DB::table('replies')->where('user_id', $user->id)->delete();
    }
}