<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\menu;
use App\Models\order;
use App\Models\table;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

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

    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {

            order::query()
            ->where('table_id', $request->table_id)
            ->where('status', false)
            ->delete();

            foreach ($request->menu_id as $key => $menu_id) {
                order::create([
                    'menu_id' => $menu_id,
                    'item_id' => $request->item_id[$key],
                    'table_id' => $request->table_id,
                    'quantity' => $request->quantity[$key],
                    'price' => $request->price[$key],
                    'total' => $request->quantity[$key] * $request->price[$key]
                ]);
            }
            toast('Successfully added to cart', "success");
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::error('Something wenty wrong...');
            return redirect()->back();
        }

        return redirect()->route('order.index');
    }
}
