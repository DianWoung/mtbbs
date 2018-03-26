<?php
/**
 * Created by PhpStorm.
 * User: mt
 * Date: 2018/3/26
 * Time: 10:24
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
}