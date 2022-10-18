<?php

namespace App\Http\Controllers;

use App\Models\table;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class TableController extends Controller
{
    public function index(): View
    {
        return view('table', [
            'tables' => table::query()->get()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $request->validate(['name' => 'required|unique:tables']);
            table::create($request->all());
            toast("table added successfully", "success");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error($e->getMessage());
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function update(Request $request, table $table): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $request->validate(['name' => ['required', Rule::unique('tables')->ignore($table)]]);
            $table->update($request->all());
            toast("table updated successfully", "success");
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Something went wrong...');
            return redirect()->back();
        }
        return redirect()->back();
    }
}
