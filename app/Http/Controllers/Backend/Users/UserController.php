<?php

namespace App\Http\Controllers\Backend\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $hitunguser = User::count();
        $user = User::all();
        return response()->json([
            'Data' => 'Data User',
            'Jumlah User' => $hitunguser,
            'Users' => $user
        ]);
    }
}
