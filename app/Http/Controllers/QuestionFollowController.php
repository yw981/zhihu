<?php

namespace App\Http\Controllers;

use App\Repositories\QuestionRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionFollowController extends Controller
{
    protected $question;

    public function __construct(QuestionRepository $question)
    {
        // $this->middleware('auth');
        $this->question = $question;
    }

    /**
     * @param $question
     * @return \Illuminate\Http\RedirectResponse
     */
//    public function follow($question)
//    {
//        Auth::user()->followThis($question);
//        return back();
//    }

    public function follow_status(Request $request)
    {
        $user = Auth::guard('api')->user();
        if($user->isFollowed($request->get('question'))) {
            return response()->json(['followed' => true]);
        }
        return response()->json(['followed' => false]);
    }

    public function followThisQuestion(Request $request)
    {
        $user = Auth::guard('api')->user();
        $question = $this->question->byId($request->get('question'));
        $followed = $user->toggleFollow($question->id);
        if(count($followed['detached']) > 0) {
            $question->decrement('followers_count');
            return response()->json(['followed' => false]);
        }
        $question->increment('followers_count');
        return response()->json(['followed' => true]);
    }
}
