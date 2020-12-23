<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Jobs\SendFilesToDropbox;
use App\Events\FileCreated;
use Log;
class FileCreatedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(FileCreated $event)
    {
        //Log::info("Se esta creando el archivo {$event->file->id}");
        SendFilesToDropbox::dispatch($event->file)->delay(now()->addMinutes(2));
    }
}
