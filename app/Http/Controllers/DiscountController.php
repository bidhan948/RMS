<?php

namespace App\Http\Controllers;

use App\Models\discount;
use App\Models\menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DiscountController extends Controller
{
    public function index(): View
    {
        return view('discount.discount', [
            'menus' => menu::query()->get(),
            'discounts' => discount::query()
                ->with('Menu')
                ->orderBy('d_to', 'DESC')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['discount_type' => 'required']);
        DB::beginTransaction();
        try {
            if ($request->discount_type) {
                foreach ($request->menu_id as $key => $menu_id) {
                    discount::create([
                        'menu_id' => $menu_id,
                        'discount' => $request->discount[$key],
                        'd_from' => $request->from[$key],
                        'd_to' => $request->to[$key]
                    ]);
                }
            } else {
                discount::create([
                    'is_flat' => true,
                    'discount' => $request->is_flat,
                    'd_from' => $request->from,
                    'd_to' => $request->to
                ]);
            }
            DB::commit();
            toast("Discount asigned successfully", "success");
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error("Something went wrong...");
        }
        return redirect()->back();
    }

    public function edit(discount $discount): View
    {
        return view('discount.edit_discount', [
            'discount' => $discount,
            'menus' => menu::query()->get()
        ]);
    }
}
