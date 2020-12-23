<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\File;
use Storage;
use Log;

class SendFilesToDropbox implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $file,$dropbox;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->dropbox = Storage::disk("dropbox")->getDriver()->getAdapter()->getClient();
        Storage::disk('dropbox')->put($this->file->public_url,Storage::get($this->file->public_url));
        Storage::delete($this->file->public_url);
        $links = $this->dropbox->createSharedLinkWithSettings(
            $this->file->public_url,
            array(
                "requested_visibility"=>"public",
            )
        );
        $this->file->name = $links["name"];
        $this->file->public_url = str_replace("dl=0","raw=1",$links['url']);
        $this->file->save();
    }
}
