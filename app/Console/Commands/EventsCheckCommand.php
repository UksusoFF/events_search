<?php

namespace App\Console\Commands;

use App\Components\EventComponent;
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

    public function handle(EventComponent $eventComponent)
    {
        try {
            $eventComponent->refresh();
        } catch (Exception $e) {
            logger()->error($e->getMessage());
            $this->error($e->getMessage());
        }
    }
}
