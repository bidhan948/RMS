<?php

namespace App\Repo;

use App\Models\menu;

class ItemRepo
{
    public function itemIndex($data)
    {
        return response()->json(
            menu::query()
                ->when($data['menu_id'], function ($q) use ($data) {
                    $q->where('id', $data['menu_id']);
                })
                ->with('Items',function($q) use ($data){
                    $q->when($data['from'] && $data['to'],function($q_child) use ($data){
                        $q_child->whereBetween('price',[$data['from'],$data['to']]);
                    });
                })
                ->whereHas('Items',function($q) use ($data){
                    $q->when($data['from'] && $data['to'],function($q_child) use ($data){
                        $q_child->whereBetween('price',[$data['from'],$data['to']]);
                    });
                })
                ->get()
        );
    }
}
