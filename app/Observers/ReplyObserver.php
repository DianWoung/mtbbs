<?php
namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;
use App\Notifications\UserDynamicsFromReply;
use Auth;

class ReplyObserver
{
    public function created(Reply $reply)
    {
        $topic = $reply->topic;
        $topic->increment('reply_count', 1);
        $topic->user->notify(new TopicReplied($reply));
        Auth::user()->broadcast(new UserDynamicsFromReply($reply));
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }
}