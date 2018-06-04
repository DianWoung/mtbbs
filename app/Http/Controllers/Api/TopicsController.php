<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use App\Transformers\TopicsTransformer;
use Illuminate\Http\Request;
use App\Models\User;

class TopicsController extends Controller
{
    public function show(Topic $topic)
    {
        return $this->response->item($topic, new TopicsTransformer());
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $this->user()->id;
        $topic->save();
        return $this->response->item($topic, new TopicsTransformer())
            ->setStatusCode(201);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);

        $topic->update($request->all());
        return $this->response->item($topic, new TopicsTransformer());
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->delete();
        return $this->response->noContent();
    }

    public function index(TopicRequest $request, Topic $topic)
    {
        $query = $topic->query();

        if ($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }

        switch ($request->order) {
            case 'recent':
                $query->recent();
                break;

            default:
                $query->recentReplied();
                break;
        }

        $topics = $query->paginate(10);
        return $this->response->paginator($topics, new TopicsTransformer());
    }

    public function userIndex(User $user, Request $request)
    {
        $topics = $user->topics()->recent()
            ->paginate(10);

        return $this->response->paginator($topics, new TopicsTransformer());
    }
}
