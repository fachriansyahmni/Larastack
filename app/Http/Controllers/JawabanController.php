<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jawaban;
use App\KomentarJawaban;
use App\Profile;
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
        $data2 = Profile::where('user_id', $data->user_id)->first();
        $data2->reputation = $data2->reputation + 15;
        $data->is_best = 1;
        $data->update();
        $data2->update();

        return redirect()->back();
    }
    public function edit($id)
    {
        $data = Jawaban::find($id);
        return view('jawaban.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'isi' => 'required'
        ]);
        $data = Jawaban::findorfail($id);
        $data_edited = [
            'jawaban' => $request->isi
        ];
        $data->update($data_edited);

        return redirect('/pertanyaan/' . $data->pertanyaan_id);
    }

    public function delete($id)
    {
        $jawaban = Jawaban::find($id)->delete();
        return redirect()->back();
    }
}
