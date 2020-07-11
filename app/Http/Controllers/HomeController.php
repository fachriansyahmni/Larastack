<?php

namespace App\Http\Controllers;

use App\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Profile;
use Validator,File,Redirect,Response;

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

    public function update(Request $request, $id)
    {
        //ambil isi kolom foto untuk hapus fisik file fotonya atau sekedar ambil nama filenya
        $photo = DB::table('profile')->select('photo')->where('id',$id)->get();
        foreach($photo as $f){
            $namaFile = $f->photo;
        }
        if(!empty($request->photo)){
            //hapus fisik file foto lama di folder img/profile
            File::delete(public_path('img/profile/'.$namaFile));
            //proses upload file foto baru
            $request->validate([
                'file' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);
            $fileName = $request->nama_lengkap.'.'.$request->photo->extension();  
            $request->photo->move(public_path('img/profile'), $fileName);
        }
        else{ //tidak ganti foto, nama file tetap foto yg lama
            $fileName = $namaFile;
        }

        // $photo = $request->file('photo')->store('profile');

        $data = DB::table('profile')
                        ->where('id', $id)
                        ->update([
                            'nama_lengkap' => $request->nama_lengkap,
                            'user_id' => $request->user_id,
                            'gender'=>$request->gender,
                            'tanggal_lahir'=>$request->tanggal_lahir,
                            'photo'=>$fileName
                        ]);
                        
        // dd($data);
        return redirect('/home');
    }
}
