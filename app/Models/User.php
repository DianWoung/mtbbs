<?php

namespace App\Models;

use App\Models\Traits\ActiveUserHelper;
use App\Models\Traits\LastActivedAtHelper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use LastActivedAtHelper;
    use ActiveUserHelper;
    use HasApiTokens;

    use Notifiable {
        notify as protected laravelNotify;
    }



    public function findForPassport($username)
    {
        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credentials['email'] = $username :
            $credentials['phone'] = $username;

        return self::where($credentials)->first();
    }

    public function notify($instance)
    {
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        $this->laravelNotify($instance);
    }

    public function broadcast($instance)
    {
        if ($this->followers == '') {
            return;
        }
        $followers = explode(',',$this->followers);
        foreach ($followers as $follower_id)
        {
            $follower = $this->find($follower_id);
            $follower->increment('notification_count');
            $follower->laravelNotify($instance);
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar', 'followers', 'following', 'phone',
        'weixin_openid', 'weixin_unionid', 'registration_id'
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
            //关注者关注列表following字段增加
            $following = trim($this->following.','.$follower_id,',');
            $this->update(['following' => $following]);
            //被关注这followers字段增加
            $follower = $this->find($follower_id);
            $followers = trim($follower->followers.','.$this->id,',');
            return $follower->update(['followers' => $followers]);
        }
        return true;
    }
    //取消关注
    public function unfollow($follower_id)
    {
        //从被关注者的followers中移除当前用户id
        $follower = $this->find($follower_id);
        $followerList = explode(',',$follower->followers);
        if (in_array($this->id, $followerList)){
            $followerList = array_diff($followerList, [$this->id]);
            $followers = trim(implode(',',$followerList),',');
            $follower->update(['followers' => $followers]);
        }
        //从当前用户的following中移除$follower_id;
        $followingList = explode(',',$this->following);
        if($this->isFollowed($follower_id)) {
            $followingList = array_diff($followingList, [$follower_id]);
            $following = trim(implode(',',$followingList),',');
            $this->update(['following' => $following]);
        }
        return true;
    }
    //检测是否在关注列表
    public function isFollowed($id)
    {
       return in_array($id, explode(',',$this->following));
    }

    //Rest omitted for brevity

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
       return [];
    }
}
