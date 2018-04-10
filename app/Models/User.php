<?php

namespace App\Models;

use App\Models\Traits\ActiveUserHelper;
use App\Models\Traits\LastActivedAtHelper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    use LastActivedAtHelper;
    use ActiveUserHelper;

    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar', 'followers'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

    //关注模块
    public function follow($follower_id)
    {
        if (!$this->isFollowed($follower_id)) {
            $followers = trim($this->followers.','.$follower_id,',');
           return $this->update(['followers' => $followers]);
        }
        return true;
    }
    //取消关注
    public function unfollow($follower_id)
    {
        $followerList = explode(',',$this->followers);
        if($this->isFollowed($follower_id)) {
            $followerList = array_diff($followerList, [$follower_id]);
            $followers = trim(implode(',',$followerList),',');
         return $this->update(['followers' => $followers]);
        }
        return true;
    }
    //检测是否在关注列表
    public function isFollowed($id)
    {
        return in_array($id, explode(',',$this->followers));
    }
}
