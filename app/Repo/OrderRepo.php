<?php

namespace App\Repo;

use App\Models\menu;
use App\Models\order;

class OrderRepo
{
    public function orderIndex($data)
    {
        return response()->json(
            order::query()
                ->with('Table', 'Menu', 'Item')
                ->where('status',false)
                ->latest()
                ->get()
                ->groupBy('table_id')
                ->values()
        );
    }


    public function orderHistoryIndex($data)
    {
        return response()->json(
            order::query()
                ->with('Table', 'Menu', 'Item')
                ->where('status',true)
                ->latest()
                ->get()
                ->groupBy('table_id')
                ->values()
        );
    }
}
