<?php

namespace App\Components;

use App\Models\Event;
use App\Sources\HtmlSource;
use App\Sources\JsonSource;

class EventComponent
{
    /**
     * @param \App\Models\Source $source
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function refresh($source)
    {
        /* @var \App\Sources\SourceInterface $src */
        switch ($source->type) {
            case 'json':
                $src = new JsonSource($source);
                break;
            case 'html':
                $src = new HtmlSource($source);
                break;
        }

        $src->getEvents()->filter(function ($event) {
            return array_has(array_filter($event), [
                'uuid',
                'title',
                'date',
            ]);
        })->each(function ($event) use ($source) {
            $params = [
                'uuid' => $event['uuid'],
                'source_id' => $source->id,
            ];
            $e = Event::firstOrNew($params);
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