<?php

namespace App\Repo;

use App\Models\menu;

class ItemRepo
{
    public function itemIndex()
    {
        return response()->json(
            menu::query()->with('Items')->get()
        );
    }
}
