<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jawaban;
use Auth;

class JawabanController extends Controller
{
    public function index($pertanyaan_id)
    {
        $jawaban = Jawaban::find($pertanyaan_id);
        return view('jawaban.index', compact(['jawaban']));
    }

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
