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
        return view('users.show', compact('user'));
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
}