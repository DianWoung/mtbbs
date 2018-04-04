<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

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

    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];



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


}
