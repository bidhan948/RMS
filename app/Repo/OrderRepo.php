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
                ->latest()
                ->get()
                ->groupBy('table_id')
                ->values()
        );
    }
}
