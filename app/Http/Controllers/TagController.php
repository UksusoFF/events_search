<?php

namespace App\Http\Controllers;

use App\Models\Source;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request, Source $source)
    {
        $tag = new Tag([
            'name' => $request->input('name'),
        ]);
        $tag->source_id = $source->id;
        $tag->save();

        return redirect()->action('EventController@index');
    }

    public function update(Request $request, Source $source, Tag $tag)
    {
        $tag->fill([
            'name' => $request->input('name'),
        ]);
        $tag->save();

        return redirect()->action('EventController@index');
    }
}