<?php
/**
 * Created by PhpStorm.
 * User: mt
 * Date: 2018/11/16
 * Time: 9:55
 */

namespace App\Http\Controllers\Admin;

use App\Models\Topic;
use App\Http\Controllers\Controller;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::paginate(15);
        return view('admin.topics.list', compact('topics'));
    }

    public function setSticky($id)
    {
        $topic = Topic::find($id);
        $topic->sticky = 1;
        $topic->save();
        return redirect()->back()->with('success', '设置成功');
    }

    public function unsetSticky($id)
    {
        $topic = Topic::find($id);
        $topic->sticky = 0;
        $topic->save();
        return redirect()->back()->with('success', '设置成功');
    }

    public function destroy($id)
    {
        Topic::destroy($id);
        return redirect()->route('admin::topics.index')->with('success', '删除成功');
    }

}