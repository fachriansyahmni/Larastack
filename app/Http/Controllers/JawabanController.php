<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jawaban;
use App\KomentarJawaban;
use Auth;

class JawabanController extends Controller
{
    public function index($pertanyaan_id)
    {
        $jawaban = Jawaban::find($pertanyaan_id);
        $komentars = KomentarJawaban::where('jawaban_id', $jawaban->id)->get();
        $totalkomentar = $komentars->count();
        return view('jawaban.index', compact(['jawaban', 'komentars', 'totalkomentar']));
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

    public function best_aswer(Request $request)
    {
        $data = Jawaban::where('id', $request->id_jawaban)->first();
        $data->is_best = 1;
        $data->update();

        return redirect()->back();
    }
}
