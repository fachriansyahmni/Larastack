<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pertanyaan;
use App\Jawaban;
use App\KomentarPertanyaan;
use Illuminate\Support\Facades\Auth;
use DB;

class PertanyaanController extends Controller
{
    public function index()
    {
        $data = Pertanyaan::latest()->paginate(5);
        $hitungdata = Pertanyaan::count();
        return view('index', compact(['data', 'hitungdata']));
    }

    public function create()
    {
        return view('pertanyaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'isi' => 'required'
        ]);

        $tags = explode(',', $request->tag);
        $data = new Pertanyaan([
            'penanya_id' => Auth::user()->id,
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tag' => implode(",", $tags)
        ]);
        $data->save();
        return redirect('/pertanyaan/' . $data->id);
    }

    public function show($id)
    {
        if ($id == null) {
            return redirect('/');
        }
        $pertanyaan = Pertanyaan::find($id);
        $jawaban = DB::table('pertanyaan')->join('jawaban', 'jawaban.pertanyaan_id', '=', 'pertanyaan.id')->where(['pertanyaan.id' => $id])->get();
        $totaljwbn = Jawaban::where('pertanyaan_id', $id)->count();
        return view('pertanyaan.show', compact(['pertanyaan', 'jawaban', 'totaljwbn']));
    }

    public function edit($id)
    {
        $data = Pertanyaan::find($id);
        return view('pertanyaan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'judul' => 'required',
            'isi' => 'required'
        ]);
        $data = Pertanyaan::findorfail($id);

        $tags = explode(',', $request->tag);
        $data_edited = [
            'judul' => $request->judul,
            'isi' => $request->isi,
            'tag' => implode(",", $tags)
        ];
        $data->update($data_edited);

        return redirect('/pertanyaan/' . $id)->with('success', 'pertanyaan berhasil diupdate');
    }

    public function delete($id)
    {
        $pertanyaan = Pertanyaan::find($id)->delete();
        $q = DB::table('jawaban')->where('pertanyaan_id', '=', $id)->delete();
        return redirect('/pertanyaan');
    }

    public function komentar($id)
    {
        $data = Pertanyaan::find($id);
        $komentars = KomentarPertanyaan::where('pertanyaan_id', $data->id)->get();
        $totalkomentar = $komentars->count();
        return view('pertanyaan.komentar', compact(['data', 'komentars', 'totalkomentar']));
    }

    public function store_comment(Request $request)
    {
        $request->validate([
            'komentar' => 'required'
        ]);
        $data = new KomentarPertanyaan([
            'isi' => $request->komentar,
            'pertanyaan_id' => $request->id_pertanyaan,
            'user_id' => Auth::user()->id,
        ]);
        $data->save();
        return redirect()->back();
    }
}
