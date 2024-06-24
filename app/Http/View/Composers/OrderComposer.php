<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Order;

class OrderComposer
{
    protected $orders;

    public function __construct(Order $orders)
    {
        $this->orders = $orders;
    }

    public function compose(View $view)
    {
        $newOrders = $this->orders->where('is_read', 0)->get();
        $newOrdersCount = $newOrders->count();
        $view->with('newOrdersCount', $newOrdersCount)->with('newOrders', $newOrders);
    }
}
