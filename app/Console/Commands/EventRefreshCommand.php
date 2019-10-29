<?php

namespace App\Console\Commands;

use App\Components\EventComponent;
use App\Mail\MessageMail;
use App\Models\Source;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Mail;

class EventRefreshCommand extends Command
{
    protected $signature = 'event:refresh';

    protected $description = 'This command run events refresh';

    protected $eventComponent;

    public function __construct(EventComponent $eventComponent)
    {
        parent::__construct();

        $this->eventComponent = $eventComponent;
    }

    public function handle()
    {
        User::all()->each(function(User $user) {
            $user->sourcesActive->each(function(Source $source) use ($user) {
                try {
                    $this->eventComponent->refresh($source);
                } catch (Exception $e) {
                    Mail::to($user->email)
                        ->send(new MessageMail(
                            'emails.events.update_failed',
                            [
                                'text' => trans('source.update.fail', [
                                    'source' => $source->title,
                                    'error' => htmlentities($e->getMessage()),
                                ]),
                            ]
                        ));
                }

                if ($source->report === 'created') {
                    $events = $source->events()->whereDate('created_at', Carbon::today())->get();
                } elseif ($source->report === 'updated') {
                    $events = $source->events()->whereDate('updated_at', Carbon::today())->get();
                } else {
                    $events = [];
                }

                Mail::to($user->email)
                    ->send(new MessageMail(
                        'emails.events.update_success',
                        [
                            'text' => trans('source.update.success', [
                                'source' => $source->title,
                            ]),
                            'events' => $events,
                        ]
                    ));
            });
        });
    }
}
