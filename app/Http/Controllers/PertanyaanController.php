<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pertanyaan;
use App\Jawaban;
use Illuminate\Support\Facades\Auth;
use DB;

class PertanyaanController extends Controller
{
    public function index()
    {
        $data = Pertanyaan::latest()->paginate(5);
        return view('index', compact('data'));
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
        return redirect('/pertanyaan')->with('success', 'Pertanyaan Behasil Di Submit');
    }

    public function show($id)
    {
        if ($id == null) {
            redirect('/');
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
}
