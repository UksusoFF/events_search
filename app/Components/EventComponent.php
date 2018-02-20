<?php

namespace App\Components;

use App\Event;
use Carbon\Carbon;

class EventComponent
{
    private $vkontakteComponent;

    public function __construct(VkontakteComponent $vkontakteComponent)
    {
        $this->vkontakteComponent = $vkontakteComponent;
    }

    /**
     * @throws \Exception
     */
    public function refresh()
    {
        Event::where('start_date', '<', Carbon::yesterday())->delete();

        $vkEvents = collect($this->vkontakteComponent->searchEvents('123')['items']);

        $vkEvents = $vkEvents->filter(function ($vkEvent) {
            return !$vkEvent['is_closed'] && array_has($vkEvent, [
                    'id',
                    'name',
                    'description',
                    'photo_200',
                    'start_date',
                ]);
        });

        foreach ($vkEvents as $vkEvent) {
            $event = Event::where('vid', $vkEvent['id'])->first();
            if (!$event) {
                $event = new Event([
                    'vid' => $vkEvent['id'],
                    'ignored' => false,
                ]);
            }
            $event->fill([
                'name' => $vkEvent['name'],
                'description' => $vkEvent['description'],
                'photo_200' => $vkEvent['photo_200'],
                'start_date' => $vkEvent['start_date'],
            ]);
            if ($event->isDirty()) {
                $event->checkMarks()->delete();
            }
            $event->save();
        }
    }
}