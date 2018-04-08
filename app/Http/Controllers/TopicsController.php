<?php

namespace App\Http\Controllers;

use Event;
use App\Events\PageView;
use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;
use Auth;
use App\Models\Link;

class TopicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function index(Request $request, Topic $topic, Link $link)
    {
        $topics = $topic->withOrder($request->order)->paginate(20);
        $links = $link->getAllCached();
        return view('topics.index', compact('topics','links'));
    }

    public function create(Topic $topic)
    {
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic','categories'));
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->route('topics.show',$topic->id)->with('message','发布成功');
    }

    public function show(Topic $topic)
    {
        Event::fire(new PageView($topic));
        $topic->timestamps = true;
        return view('topics.show', compact('topic'));
    }

    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        $categories = Category::all();
        return view('topics.create_and_edit', compact('topic','categories'));
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return redirect()->route('topics.show', $topic->id)->with('success','更新成功');
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();

        return redirect()->route('topics.index')->with('success', '成功');
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'url' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->image) {
            // 保存图片到本地
            $result = $uploader->save($request->image, 'topics', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['url'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }

    public function searching(Request $request)
    {
        $query = $request->input('query');
        $result = Topic::search($query);
        $num = $result->get()->count();
        $topics = $result->paginate(10);


        return view('topics._search',compact(['topics','num','query']));
    }
}
