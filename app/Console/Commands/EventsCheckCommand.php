<?php

namespace App\Console\Commands;

use App\Components\VkontakteComponent;
use App\Event;
use Exception;
use Illuminate\Console\Command;

class EventsCheckCommand extends Command
{
    protected $signature = 'events:check';
    protected $description = 'This command check Vkontakte api for events update.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(VkontakteComponent $vkontakteComponent)
    {
        try {
            $vkEvents = collect($vkontakteComponent->searchEvents('123')['items']);

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
        } catch (Exception $e) {
            logger()->error($e->getMessage());
            $this->error($e->getMessage());
        }
    }
}
