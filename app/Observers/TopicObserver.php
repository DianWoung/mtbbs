<?php

namespace App\Observers;

use App\Models\Topic;
use App\Notifications\UserDynamicsFromTopic;
use Auth;

class TopicObserver
{
    public function created(Topic $topic)
    {
        Auth::user()->broadcast(new UserDynamicsFromTopic($topic));
    }
    public function saving(Topic $topic)
    {
        //$topic->body = clean($topic->body, 'user_topoc_body');
        $topic->excerpt = make_excerpt($topic->body);
    }

    public function deleted(Topic $topic)
    {
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }
}