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
     */
    public function refresh()
    {
        Event::where('start_date', '<', Carbon::yesterday())->delete();

        foreach (User::all() as $user) {
            foreach ($user->sources as $source) {
                /** @var \App\Sources\SourceInterface $src */
                switch ($source) {
                    case 'json':
                        $src = new JsonSource($source);
                        break;
                    case 'html':
                        $src = new HtmlSource($source);
                        break;
                }
                $src->getEvents();

            }
        }

        //TODO: Fix null.
        User::pluck('city_id')->unique()->each(function ($cityId) {
            $vkEvents = collect($this->vkontakteComponent->searchEvents($cityId));

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
        });
    }
}