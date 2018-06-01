<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use App\Transformers\TopicsTransformer;
use Illuminate\Http\Request;


class TopicsController extends Controller
{
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $this->user()->id;
        $topic->save();
        return $this->response->item($topic, new TopicsTransformer())
            ->setStatusCode(201);
    }
}