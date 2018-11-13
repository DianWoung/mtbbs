<?php
namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class DashBoardController extends Controller
{
    public function home()
    {
        return view('admin.dashboard.dashboard');
    }
}