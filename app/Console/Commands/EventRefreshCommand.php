<?php

namespace App\Console\Commands;

use App\Components\EventComponent;
use App\Models\Source;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

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
        User::all()->each(function (User $user) {
            $user->events()->where('date', '<', Carbon::yesterday())->delete();
            $user->sources->each(function (Source $source) {
                try {
                    $this->eventComponent->refresh($source);
                    $this->info(trans('source.update.success', [
                        'source' => $source->title,
                    ]));
                } catch (Exception $e) {
                    $this->error(trans('source.update.fail', [
                        'source' => $source->title,
                        'error' => $e->getMessage(),
                    ]));
                }
            });
        });
    }
}
