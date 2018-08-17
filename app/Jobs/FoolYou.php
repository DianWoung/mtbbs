<?php

namespace App\Jobs;

use App\Contracts\FoolContract;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Topic;

class FoolYou implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $fool, $topic;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FoolContract $foolContract, Topic $topic)
    {
        $this->fool = $foolContract;
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->fool->doFool($this->topic->title);
    }
}
