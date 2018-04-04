<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Session\Store;
use App\Events\PageView;

class PageViewListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PageView $event)
    {
        $topic = $event->topic;
        if (!$this->hasViewedTopic($topic)) {
            $topic->timestamps=false;
            $topic->cache_view = $topic->cache_view + 1;
            $topic->save();
            $this->storeViewedTopic($topic);
        }
    }

    protected function hasViewedTopic($post)
    {
        return array_key_exists($post->id, $this->getViewedTopics());
    }

    protected function getViewedTopics()
    {
        return $this->session->get('viewed_Topics', []);
    }

    protected function storeViewedTopic($post)
    {
        $key = 'viewed_Topics.'.$post->id;

        $this->session->put($key, time());
    }
}
