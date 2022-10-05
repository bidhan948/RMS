<?php

namespace App\Http\Controllers;

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
            'menus' => menu::query()->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(['discount_type' => 'required']);
        DB::beginTransaction();
        try {
            DB::commit();
            toast("Discount asigned successfully", "success");
        } catch (\Exception $e) {
            DB::rollBack();
            Alert::error("Something went wrong...");
        }

        return redirect()->back();
    }
}
