<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        $user->fill([
            'city_id' => $request->input('city_id'),
        ]);
        $user->save();

        return redirect()->action('EventController@index');
    }
}