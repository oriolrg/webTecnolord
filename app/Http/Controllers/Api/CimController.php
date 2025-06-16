<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CimController extends Controller
{
    public function index()
    {
        return Summit::all();
    }

    public function completed()
    {
        $user = User::find(session('user_id'));
        return $user->summits()->get();
    }

    public function complete($id)
    {
        $user = User::find(session('user_id'));
        $summit = Summit::findOrFail($id);

        $user->summits()->syncWithoutDetaching([
            $summit->id => ['completed_at' => now()]
        ]);

        return response()->json(['message' => 'Cim marcat com completat']);
    }
}
