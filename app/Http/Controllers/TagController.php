<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $tag = new Tag([
            'name' => $request->input('name'),
        ]);
        $tag->user_id = auth()->id();
        $tag->save();

        return redirect()->action('EventController@index');
    }

    public function update(Request $request, Tag $tag)
    {

        $tag->fill([
            'name' => $request->input('name'),
        ]);
        $tag->save();

        return redirect()->action('EventController@index');
    }
}