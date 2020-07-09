<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jawabankamu' => 'required',
        ]);
        $data = new Jawaban([
            'jawaban' => $request->jawabankamu,
            'user_id' => Auth::user()->id,
            'pertanyaan_id' => $request->id_pertanyaan,
        ]);
        $data->save();
        return redirect('/pertanyaan/' . $request->id_pertanyaan)->with('success', 'Behasil Di Submit');
    }
}
