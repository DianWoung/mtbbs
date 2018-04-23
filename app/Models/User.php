<?php

namespace App\Models;

use App\Models\Traits\ActiveUserHelper;
use App\Models\Traits\LastActivedAtHelper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $phone
 * @property string|null $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $avatar
 * @property string|null $introduction
 * @property int $notification_count
 * @property string|null $last_actived_at
 * @property string|null $followers
 * @property string|null $following
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[] $replies
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Topic[] $topics
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFollowers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFollowing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereIntroduction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastActivedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNotificationCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
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
        'weixin_openid', 'weixin_unionid',
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
