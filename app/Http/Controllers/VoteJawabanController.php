<?php

namespace App\Http\Controllers;

use App\Jawaban;
use App\Vote_Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoteJawabanController extends Controller
{
    public function vote(Request $request)
    {
        if ($request->vote == 0) {
            $data = new Vote_Jawaban([
                'user_id' => Auth::user()->id,
                'jawaban_id' => $request->jawaban_id,
                'vote' => 0
            ]);
        } elseif ($request->vote == 1) {
            $data = new Vote_Jawaban([
                'user_id' => Auth::user()->id,
                'jawaban_id' => $request->jawaban_id,
                'vote' => 1
            ]);
        } else {
            return "/";
        }
        $data->save();
        $repuser = Jawaban::find($request->jawaban_id);
        if ($request->vote == 0) {
            $data = $repuser->vote - 1;
        } elseif ($request->vote == 1) {
            $data = $repuser->vote + 1;
        } else {
            return "/";
        }
        $repuser->vote = $data;
        $repuser->update();
        return redirect('/pertanyaan/' . $repuser->pertanyaan_id);
    }
}
