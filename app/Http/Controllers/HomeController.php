<?php

namespace App\Http\Controllers;

use App\Pertanyaan;
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
        $pertanyaan = Pertanyaan::where('penanya_id', $data->id)->get();
        return view('profile.index', compact('data', 'pertanyaan'));
    }
    public function edit()
    {
        $data = DB::table('users')->join('profile', 'users.id', '=', 'profile.user_id')->where('users.id', Auth::user()->id)->first();
        return view('profile.edit', compact('data'));
    }

    public function update($user_id, Request $request)
    {

        $jawaban = DB::table('profile')
            ->where('user_id', $user_id)
            ->update([
                'nama_lengkap' => $request->nama_lengkap,
                'user_id' => $request->user_id,
                'gender' => $request->gender,
                'tanggal_lahir' => $request->tanggal_lahir
            ]);
        // dd($jawaban);
        return redirect('/home');
    }
}
