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

    public function index(Request $request, Topic $topic, Link $link, User $user)
    {
        $sticky = $topic->where('sticky', 1)->get();
        $topics = $topic->where('sticky', 0)->withOrder($request->order)->paginate(20);;
        $links = $link->getAllCached();
        $active_users = $user->getActiveUsers();
        return view('topics.index', compact('topics','links','active_users','sticky'));
    }

    public function create(Topic $topic)
    {
        return view('topics.create_and_edit', compact('topic'));
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
        return view('topics.create_and_edit', compact('topic'));
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

    public function getFavors($topic_id)
    {
        $attribute = Topic::find($topic_id)->favors;
        $arr = [];
        if (is_numeric($attribute)){
            $arr[0] = User::find($attribute)->only('id','avatar');
        } else if ($attribute != ''){
            $ids = explode(',', $attribute);
            foreach($ids as $id)
            {
                array_push($arr, User::find($id)->only('id','avatar'));
            }
        } else {
            $arr = [];
        }
        return $arr;
    }

    public function favor($topic_id, $user_id)
    {
        $topic = Topic::find($topic_id);
        $topic->favor($user_id);
        return [
            'status' => true
        ];
    }

    public function unFavor($topic_id, $user_id)
    {
        $topic = Topic::find($topic_id);
        $topic->unFavor($user_id);
        return [
          'status' => true
        ];
    }
}
