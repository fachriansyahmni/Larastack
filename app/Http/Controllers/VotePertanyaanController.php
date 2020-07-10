<?php

namespace App\Http\Controllers;

use App\Vote_Pertanyaan;
use Illuminate\Http\Request;

class VotePertanyaanController extends Controller
{
    public function vote(Request $request)
    {
        if ($request->vote == 0) {
            $data = new Vote_Pertanyaan([
                'user_id' => Auth::user()->id,
                'pertanyaan_id' => $request->pertanyaan_id,
                'vote' => 0
            ]);
        } elseif ($request->vote == 1) {
            $data = new Vote_Pertanyaan([
                'user_id' => Auth::user()->id,
                'pertanyaan_id' => $request->pertanyaan_id,
                'vote' => 1
            ]);
        } else {
            return "/";
        }
        $data->save();
        $repuser = Pertanyaan::find($request->pertanyaan_id);
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
