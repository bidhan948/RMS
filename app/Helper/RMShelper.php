<?php

namespace App\Helper;

use App\Models\order;
use Illuminate\Support\Str;

class RMShelper
{
    public function generateRandomToken()
    {
        $token = Str::random(32);

        if (order::query()->where('token',$token)->count()) {
            (new RMShelper())->generateRandomToken();
        }

        return $token;
    }
}