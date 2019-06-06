<?php

namespace App\Listeners;

use Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueryLogListener
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
    public function handle($event)
    {
        $sqlWithPlaceholders = str_replace(['%', '?'], ['%%', '%s'], $event->sql);
        $bindings = $event->connection->prepareBindings($event->bindings);
        $pdo = $event->connection->getPdo();
        $realSql = vsprintf($sqlWithPlaceholders, array_map([$pdo, 'quote'], $bindings));
        $duration = $this->formatDuration($event->time / 1000);

        if (config('app.env') != 'production') {
            Log::channel('query')->debug(sprintf('[%s] %s | %s: %s', $duration, $realSql, request()->method(), request()->getRequestUri()));
        }
    }
    /**
     * Format duration.
     *
     * @param float $seconds
     *
     * @return string
     */
    private function formatDuration($seconds)
    {
        if ($seconds < 0.001) {
            return round($seconds * 1000000).'μs';
        } elseif ($seconds < 1) {
            return round($seconds * 1000, 2).'ms';
        }
        return round($seconds, 2).'s';
    }
}
