<?php

namespace App\Http\Controllers;

use App\Components\EventComponent;
use App\Models\Source;
use DB;
use Exception;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Components\EventComponent $eventComponent
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function store(Request $request, EventComponent $eventComponent)
    {
        $source = new Source();
        $source->user_id = auth()->id();

        return $this->fillCheckAndSave($request, $source, $eventComponent);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Source $source
     * @param \App\Components\EventComponent $eventComponent
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function update(Request $request, Source $source, EventComponent $eventComponent)
    {
        return $this->fillCheckAndSave($request, $source, $eventComponent);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Source $source
     * @param \App\Components\EventComponent $eventComponent
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    private function fillCheckAndSave(Request $request, Source $source, EventComponent $eventComponent)
    {
        DB::beginTransaction();

        try {
            $source->fill($request->only([
                'title',
                'type',
                'source',
                'map_items',
                'map_id',
                'map_title',
                'map_url',
                'map_description',
                'map_image',
                'map_date',
                'map_date_format',
                'map_date_regex',
                'report',
            ]));
            $source->tags = json_decode($request->input('tags', '[]'), true);
            $source->disabled = $request->has('disabled');
            $source->save();

            if (!$source->disabled) {
                $eventComponent->refresh($source);
            }

            DB::commit();

            $message = [
                'level' => 'success',
                'text' => trans('source.update.success', [
                    'source' => $source->title,
                ]),
            ];
        } catch (Exception $e) {
            DB::rollBack();

            $message = [
                'level' => 'error',
                'text' => trans('source.update.fail', [
                    'source' => $source->title,
                    'error' => htmlentities($e->getMessage()),
                ]),
            ];
        }

        return redirect()->action('EventController@index')->with([
            'messages' => [
                $message,
            ],
        ]);
    }
}
