<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\menu;
use App\Repo\ItemRepo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class ItemController extends Controller
{
    protected $itemRepo;

    public function __construct(ItemRepo $obj)
    {
        $this->itemRepo = $obj;
    }

    public function index()
    {
        return view('item.item', [
            'menus' => menu::query()->with('Items')->get()
        ]);
    }

    public function itemReport()
    {
        return $this->itemRepo->itemIndex();
    }

    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $validate = $request->validate([
                'name' => 'required|unique:menus',
                'menu_id' => 'required',
                'discount' => 'present',
                'price' => 'required',
                'description' => 'present'
            ]);

            item::create($validate);
            toast("Item added successfully", "success");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Something went wrong...');
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function edit(item $item): View
    {
        return view('item.edit_item', [
            'item' => $item,
            'menus' => menu::query()->get()
        ]);
    }

    public function update(Request $request, item $item): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $validate = $request->validate([
                'name' => ['required', Rule::unique('items')->ignore($item)],
                'menu_id' => 'required',
                'discount' => 'present',
                'price' => 'required',
                'description' => 'present'
            ]);

            $item->update($validate);
            toast("Item updated successfully", "success");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Something went wrong...');
            return redirect()->back();
        }
        return redirect()->route('item.index');
    }
}
