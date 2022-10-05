<?php

namespace App\Http\Controllers;

use App\Helper\MediaHelper;
use App\Models\menu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class MenuController extends Controller
{
    public function index(): View
    {
        return view('menu', [
            'menus' => menu::query()->get()
        ]);
    }

    public function store(Request $request, MediaHelper $helper): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $request->validate(['name' => 'required|unique:menus']);
            if ($request->hasFile('image')) {
                $image = $helper->uploadSingleImage($request->image);
            }
            menu::create($request->except('image') + ['image' => $image ?? null]);
            toast("Menu added successfully", "success");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            // Alert::error('Something went wrong...');
            Alert::error($e->getMessage());
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function update(Request $request, menu $menu, MediaHelper $helper): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $request->validate(['name' => ['required', Rule::unique('menus')->ignore($menu)]]);
            if ($request->has('image')) {
                $image = $helper->uploadSingleImage($request->image);
            }
            $menu->update($request->except('image') + ['image' => $image ?? $menu->image]);
            toast("Menu updated successfully", "success");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Something went wrong...');
            return redirect()->back();
        }
        return redirect()->back();
    }
}
