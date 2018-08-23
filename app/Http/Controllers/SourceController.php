<?php

namespace App\Http\Controllers;

use App\Models\Source;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    public function index(Request $request)
    {
        return view('sources.index', [
            'sources' => Source::paginate(),
        ]);
    }

    public function store(Request $request)
    {
        $source = new Source($request->only([
            'title',
            'type',
            'source',
            'map_items',
            'map_id',
            'map_title',
            'map_description',
            'map_image',
            'map_date',
            'map_date_format',
        ]));
        $source->user_id = auth()->id();
        $source->save();

        return redirect()->action('EventController@index');
    }

    public function update(Request $request, Source $source)
    {
        $source->fill($request->only([
            'type',
            'source',
            'map_items',
            'map_id',
            'map_title',
            'map_description',
            'map_image',
            'map_date',
            'map_date_format',
        ]));
        $source->save();

        return redirect()->action('EventController@index');
    }
}