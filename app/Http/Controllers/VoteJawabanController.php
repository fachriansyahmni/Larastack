<?php

namespace App\Http\Controllers;

use App\Jawaban;
use App\Vote_Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Profile;

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
        $votepenjawab = Jawaban::find($request->jawaban_id);
        $repuserpenjawab = Profile::where('user_id', $votepenjawab->user_id)->first();
        $userpemberivote = Profile::where('user_id', Auth::user()->id)->first();
        if ($request->vote == 0) {
            $data = $votepenjawab->vote - 1;
            $sendvoter = $userpemberivote->reputation - 1;
            $userpemberivote->reputation = $sendvoter;
            $userpemberivote->update();
        } elseif ($request->vote == 1) {
            $data = $votepenjawab->vote + 1;
            $repjawab = $repuserpenjawab->reputation + 10;
            $repuserpenjawab->reputation = $repjawab;
            $repuserpenjawab->update();
        } else {
            return "/";
        }
        $votepenjawab->vote = $data;
        $votepenjawab->update();
        return redirect('/pertanyaan/' . $votepenjawab->pertanyaan_id);
    }
}
