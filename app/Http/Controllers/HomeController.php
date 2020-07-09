<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = DB::table('users')->join('profile', 'users.id', '=', 'profile.user_id')->where('users.id', Auth::user()->id)->first();
        return view('profile.index', compact('data'));
    }
}
