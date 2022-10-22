<?php

namespace App\Http\Controllers;

use App\Models\item;
use Illuminate\Http\Request;

class ApiHelperController extends Controller
{
    public function getItemByMenu()
    {
        $items = item::query()->where('menu_id', request('menu_id'))->get();
        $html = '';
        $html .= '<select name="item_id[]" id="item_id_' . request('index') . '" class="form-control form-control-sm" onchange="returnPrice(' . request('index') . ')">
                  <option value="">--SELECT--</option>';
        foreach ($items as $item) {
            $html .= '<option value="' . $item->id . '">' . $item->name . '</option>';
        }
        $html .= '</select>';
        $data['html'] = $html;
        return response()->json($data);
    }

    public function getItemPrice()
    {
        return response()->json(item::query()->where('id', request('item_id'))->first());
    }
}
