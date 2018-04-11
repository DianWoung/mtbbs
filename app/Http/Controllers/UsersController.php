<?php
/**
 * Created by PhpStorm.
 * User: mt
 * Date: 2018/3/26
 * Time: 10:24
 */

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(User $user)
    {
        $user->followingCount = $this->setFollowers($user->following);
        $user->followersCount = $this->setFollowers($user->followers);
        $user->topicsCount = $user->topics->count();
        $type = 'tab';
        return view('users.show', compact('user','type'));
    }

    private function setFollowers($attribute)
    {
         if (is_numeric($attribute)){
            $attribute = 1;
        } else if ($attribute != ''){
             $attribute = count(explode(',',$attribute));
         } else {
            $attribute = 0;
        }
        return $attribute;
    }

    private function getFollowers($attribute)
    {
        $arr = [];
        if (is_numeric($attribute)){
            $arr[0] = User::find($attribute);
        } else if ($attribute != ''){
            $ids = explode(',', $attribute);
            foreach($ids as $id)
            {
                array_push($arr, User::find($id));
            }
        } else {
            $arr = [];
        }
        return $arr;
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);
        $data = $request->all();
        if($request->avatar){
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success','资料更新成功');
    }

    public function follow(Request $request)
    {
        $flower_id = $request->input('flower_id');
        $status = Auth::user()->follow($flower_id);
        return [
            'status' => $status
        ];
    }
    public function unfollow(Request $request)
    {
        $flower_id = $request->input('flower_id');
        $status = Auth::user()->unfollow($flower_id);
        return [
          'status' => $status
        ];
    }

    public function followers($id, $tag)
    {
        $user = User::find($id);
        $user->followingCount = $this->setFollowers($user->following);
        $user->followersCount = $this->setFollowers($user->followers);
        $user->topicsCount = $user->topics->count();
        if ($tag == 'followers') {
            $followers = $this->getFollowers($user->followers);
        } else {
            $followers = $this->getFollowers($user->following);
        }
        $type = 'followers';
        return view('users.show', compact('user','type', 'followers', 'tag'));
    }
}