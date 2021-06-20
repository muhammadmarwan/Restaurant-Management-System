<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Carbon\Carbon;

class Now extends AbstractWidget
{
    public $reloadTimeout = 60;

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $now = Carbon::now()->format('g:i A');

        return view('widgets.now', [
            'now' => $now,
            'config' => $this->config,
        ]);
    }
}
