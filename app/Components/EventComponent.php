<?php

namespace App\Components;

use App\Models\Event;
use App\Models\Source;
use App\Sources\DvizhSource;
use App\Sources\HtmlSource;
use App\Sources\JsonSource;
use App\Sources\VkCoverSource;
use App\Sources\VkSearchSource;
use Carbon\Carbon;
use Exception;

class EventComponent
{
    /**
     * @param \App\Models\Source $source
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function refresh(Source $source): void
    {
        /* @var \App\Sources\SourceInterface $src */
        switch ($source->type) {
            case 'html':
                $src = new HtmlSource($source);
                break;
            case 'json':
                $src = new JsonSource($source);
                break;
            case 'vk_cover':
                $src = new VkCoverSource($source);
                break;
            case 'vk_search':
                $src = new VkSearchSource($source);
                break;
            case 'dvizh':
                $src = new DvizhSource($source);
                break;
        }

        $events = $src->getEvents()->filter(function($event) {
            return array_has(array_filter($event), [
                'uuid',
                'title',
                'date',
            ]);
        });

        if ($events->isEmpty()) {
            throw new Exception('Events not found!');
        }

        $events->each(function($event) use ($source) {
            $e = Event::firstOrNew([
                'uuid' => $event['uuid'],
                'source_id' => $source->id,
            ]);
            $e->fill([
                'title' => $event['title'],
                'url' => $event['url'],
                'description' => $event['description'],
                'image' => $event['image'],
                'date' => $event['date'],
            ]);
            $e->save();
        });

        $source->events()->whereDate('date', '<=', Carbon::yesterday())->delete();
    }
}
