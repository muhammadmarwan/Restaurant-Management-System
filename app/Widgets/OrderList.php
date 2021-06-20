<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\KitchenOrder;

class OrderList extends AbstractWidget
{
    public $reloadTimeout = 5;
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
        $orders = KitchenOrder::orderBy('created_at', 'desc')->get();

        return view('widgets.order_list', [
            'orders' => $orders,
            'config' => $this->config,
        ]);
    }
}
