<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\table;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('order.order');
    }

    public function create(): View
    {
        return view('order.create_order', [
            'menus' => menu::query()->get(),
            'tables' => table::query()->get()
        ]);
    }
}
