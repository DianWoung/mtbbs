<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

/**
 * App\Models\Topic
 *
 * @property int $id
 * @property string $title
 * @property string $body
 * @property int $user_id
 * @property int $category_id
 * @property int $reply_count
 * @property int $view_count
 * @property int $last_reply_user_id
 * @property int $order
 * @property string $excerpt
 * @property string|null $slug
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $favors
 * @property int $sticky
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reply[] $replies
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic recent()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic recentReplied()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereFavors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereLastReplyUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereReplyCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereSticky($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic whereViewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Topic withOrder($order)
 * @mixin \Eloquent
 */
class Topic extends Model
{
    use Searchable;

    public function searchableAs()
    {
        return 'topics_title_index';
    }

    public function toSearchableArray()
    {
        return $this->only('id','title','body');
    }

    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug', 'favors'];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent':
                $query = $this->recent();
                break;
            default:
                $query = $this->recentReplied();
                break;
        }

        return $query->with('user', 'category');
    }

    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug]));
    }

    public function favor($user_id)
    {
        if (!$this->isFavored($user_id)) {
            $favors = trim($this->favors.','.$user_id,',');
            $this->update(['favors' => $favors]);
        }
        return true;
    }

    public function unFavor($user_id)
    {
        $favors = explode(',',$this->favors);
        if ($this->isFavored($user_id)) {
            $favors = array_diff($favors, [$user_id]);
            $favorsList = trim(implode(',',$favors),',');
            $this->update(['favors' => $favorsList]);
        }
        return true;
    }

    public function isFavored($id)
    {
        return in_array($id, explode(',',$this->favors));
    }

}
