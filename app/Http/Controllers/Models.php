<?php

namespace App\Http\Controllers;

use App\Models\Models as MM;
use Illuminate\Http\Request;

class Models extends Controller
{
    public function getAllModels()
    {
        $models = MM::all()->toArray();

        return view('public.models', [
            'models' => $models
        ]);
    }
}
