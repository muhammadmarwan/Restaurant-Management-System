<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\KitchenOrder;
use App\Models\KitchenOrderItems;
use Carbon\Carbon;

class RecentOrder extends AbstractWidget
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
        $orders = KitchenOrder::where('status',0)->get();

        foreach($orders as $val)
        {
            $items = KitchenOrderItems::where('kitchen_order_id',$val->transaction_id)
                    ->where('status',0)
                    ->get();

            $val->items = $items;        
        }


        return view('widgets.recent_order', [
            'order' => $orders,
            'config' => $this->config,
        ]);
    }
}
