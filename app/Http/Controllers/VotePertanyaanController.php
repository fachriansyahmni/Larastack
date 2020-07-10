<?php

namespace App\Http\Controllers;

use App\Vote_Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Pertanyaan;
use App\Profile;

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
        $votepertanyaan = Pertanyaan::find($request->pertanyaan_id);
        $repuserpenanya = Profile::where('user_id', $votepertanyaan->penanya_id)->first();
        $userpemberivote = Profile::where('user_id', Auth::user()->id)->first();
        if ($request->vote == 0) {
            $data = $votepertanyaan->vote - 1;
            $sendvoter = $userpemberivote->reputation - 1;
            $userpemberivote->reputation = $sendvoter;
            $userpemberivote->update();
        } elseif ($request->vote == 1) {
            $data = $votepertanyaan->vote + 1;
            $repnanya = $repuserpenanya->reputation + 10;
            $repuserpenanya->reputation = $repnanya;
            $repuserpenanya->update();
        } else {
            return "/";
        }
        $votepertanyaan->vote = $data;
        $votepertanyaan->update();
        return redirect('/pertanyaan/' . $votepertanyaan->id);
    }
}
