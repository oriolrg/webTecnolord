<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PrivateController extends Controller
{
    public function index(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/strava/auth');
        }

        $user = User::find($userId);

        return response()->json([
            'missatge' => 'Usuari autenticat',
            'usuari' => $user
        ]);
    }
}
