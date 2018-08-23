<?php

namespace App\Components;

use App\Models\Event;
use App\Models\User;
use App\Sources\HtmlSource;
use App\Sources\JsonSource;
use Carbon\Carbon;

class EventComponent
{
    /**
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refresh()
    {
        Event::where('date', '<', Carbon::yesterday())->delete();

        $events = collect();

        foreach (User::all() as $user) {
            foreach ($user->sources as $source) {
                /* @var \App\Sources\SourceInterface $src */
                switch ($source->type) {
                    case 'json':
                        $src = new JsonSource($source);
                        break;
                    case 'html':
                        $src = new HtmlSource($source);
                        break;
                }
                $events = $events->merge($src->getEvents());
            }
        }

        $events->filter(function ($event) {
            return array_has(array_filter($event), [
                'uuid',
                'title',
                'date',
            ]);
        })->each(function ($event) {
            $e = Event::where('uuid', $event['uuid'])->firstOrNew([
                'uuid' => $event['uuid'],
            ]);
            $e->fill([
                'title' => $event['title'],
                'description' => $event['description'],
                'image' => $event['image'],
                'date' => $event['date'],
            ]);
            $e->save();
        });
    }
}