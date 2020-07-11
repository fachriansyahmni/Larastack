<?php

namespace App\Http\Controllers;

use App\KomentarJawaban;
use Illuminate\Http\Request;
use Auth;

class KomentarJawabanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'komentar' => 'required'
        ]);
        $data = new KomentarJawaban([
            'isi' => $request->komentar,
            'jawaban_id' => $request->id_jawaban,
            'user_id' => Auth::user()->id,
        ]);
        $data->save();
        return redirect('/jawaban/' . $request->id_jawaban)->with('success', 'Behasil Di Submit');
    }
}
