<?php

namespace App\Http\Controllers;

use App\Models\Github;
use App\Models\Vote;
use Auth;
use Request;

class VoteController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function index(Request $request) {
        if(Request::ajax()) {
            if($request::has('github_id') && $request::has('action')) {
                if($request::get('action') == 'add') {
                    $count = Auth::user()->votes_count;
                    if($count >= env('VOTE_LIMIT', 10)) {
                        return response()->json([
                            'status' => "You excess the limit of ".env('VOTE_LIMIT')." votes"
                        ]);
                    }

                    if(Github::find($request::get('github_id'))) {
                        if(Vote::updateOrCreate([
                            'github_id' => $request::get('github_id'),
                            'user_id'   => Auth::user()->id
                        ])) {
                            return response()->json([
                                "status" => "success",
                                'vote'   => Vote::where('github_id', $request::get('github_id'))->count()
                            ]);
                        } else {
                            return response()->json(["status" => "error"]);
                        }
                    }
                }
                if($request::get('action') == 'remove') {
                    if(Vote::where('github_id', $request::get('github_id'))->where('user_id', Auth::user()->id)->delete()) {
                        return response()->json([
                            "status" => "success",
                            'vote'   => Vote::where('github_id', $request::get('github_id'))->count()
                        ]);
                    } else {
                        return response()->json(["status" => "error"]);
                    }
                }
            }
            return response()->json(["status" => "Bad param"]);
        } else {
            return response()->json(["status" => "Bad request"]);
        }
    }

    public function rows() {
        $rows = \App\Models\Github::select(\DB::raw('github.*, (SELECT count(user_id) from votes WHERE github_id = github.id) as votes'))
            ->where('state', 'open')
            ->orderBy('votes', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('rows')->with(compact('rows'));
    }

}

?>