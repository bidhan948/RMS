<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\menu;
use App\Models\order;
use App\Models\table;
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

    public function getPreviousLog()
    {
        $html = '';

        $orders = order::query()
            ->where('table_id', request('table_id'))
            ->where('status', false)
            ->with('Item')
            ->get();

        $menus = menu::query()->get();

        foreach ($orders as $key => $order) {
            $html .= '<tr id="row_' . $key . '">
                        <td class="text-center">
                            <select name="menu_id[]" id="menu_id_' . $key . '" class="form-control form-control-sm"
                                onchange="returnItem(' . $key . ')">';

            foreach ($menus as $menu) {
                $html .= '<option value="'.$menu->id.'"' . ($menu->id == $order->menu_id ? "selected" : "") . '>' . $menu->name . '</option>';
            }
            $html .= '</select>
                        </td>
                        <td class="text-center" id="td_item_' . $key . '">
                            <select name="item_id[]" id="item_id_' . $key . '" class="form-control form-control-sm"
                                onchange="returnPrice(' . $key . ')">
                                <option value="' . $order->item_id . '">' . $order->Item->name . '</option></select>
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control form-control-sm" name="quantity[]" id="quantity_' . $key . '"
                                value="' . $order->quantity . '" oninput="calculateRowTotal(' . $key . ')">
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control form-control-sm" name="price[]" id="price_' . $key . '"
                              value="' . $order->price . '"  readonly>
                        </td>
                        <td class="text-center">
                            <input type="number" class="form-control form-control-sm total" name="total[]" id="total_' . $key . '"
                            value="' . $order->total . '"  readonly>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-danger mt-2" onclick="removeRow(' . $key . ')"><i class="fa-solid fa-times px-1"></i> Remove</a>
                        </td>
                    </tr>';
        }
        $data['html'] = $html;
        $data['grand_total'] = $orders->sum('total');
        $data['count'] = $orders->count() ? true : false;

        return response()->json($data);
    }
}
