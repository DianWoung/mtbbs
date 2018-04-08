<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Link;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic, Link $link)
    {
        $topics = $topic->withOrder($request->order)
                    ->where('category_id', $category->id)
                    ->paginate(20);
        $links = $link->getAllCached();

        return view('topics.index',compact('topics','category','links'));
    }
}
