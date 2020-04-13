<?php

namespace App\Http\Controllers\Api;

use App\Events\AnswerEvent;
use App\Http\Controllers\Controller;
use App\Answer;
use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class AnswersController extends Controller
{

    public function get(Request $request){

        $answer_list = array();

        $answer = Answer::where('question_id', request('question_id'))
            ->get();
        $i = 0;
        foreach ($answer as $ans){
            $nb_bad = 0;
            $nb_good = 0;
            $match_good = ['answer_id' => $ans['id'], 'type' => "up"];
            $nb_good = Rate::where($match_good)
                ->count(DB::raw('DISTINCT user_id'));

            $match_bad = ['answer_id' => $ans['id'], 'type' => "down"];
            $nb_bad = Rate::where($match_bad)
                ->count(DB::raw('DISTINCT user_id'));


            $nb_rate = ($nb_good - $nb_bad) * (($nb_good+1)/($nb_bad+1));
            $nb_rate = round ( $nb_rate );

            $answer_list[$i]['id'] = $ans['id'];
            $answer_list[$i]['content'] = $ans['content'];
            $answer_list[$i]['user_id'] = $ans['user_id'];
            $answer_list[$i]['question_id'] = $ans['question_id'];
            $answer_list[$i]['like'] = $nb_good;
            $answer_list[$i]['dislike'] = $nb_bad;
            $answer_list[$i]['rate'] = $nb_rate;
            $i++;
        }

        $answer_list = collect($answer_list)->sortBy('rate')->reverse();

        $data = array();
        $i = 0;
        foreach ($answer_list as $ans_list){
            $data[$i]['id'] = $ans_list['id'];
            $data[$i]['content'] = $ans_list['content'];
            $data[$i]['user_id'] = $ans_list['user_id'];
            $data[$i]['question_id'] = $ans_list['question_id'];
            $data[$i]['like'] = $ans_list['like'];
            $data[$i]['dislike'] = $ans_list['dislike'];
            $data[$i]['vote'] = $ans_list['rate'];
            $i++;
        }

        return response()->json(['data'=>$data],200, [], JSON_NUMERIC_CHECK);

    }

    public function give(Request $request){

        $upload = "ok";

        $answer = Answer::create([
            'content'=> request('content'),
            'user_id' => request('user_id'),
            'question_id' => request('question_id')
        ]);

        if($request->hasFile('video')){
            $upload = "okk";
            $fileName = 'answer';
            $request->file('video')->move(public_path("/video/question"), $fileName);
        }
        event(new AnswerEvent("Quelqu'un a répondu à votre question"));
        $end = array($answer);

        return response()->json(['data'=>$end],200, [], JSON_NUMERIC_CHECK);

    }

    public function delete(Request $request){

        $answer = Answer::findOrFail(request('answer_id'));
        $answer->delete();

        return 'success';

    }

    public function rate(Request $request){

        $match = ['user_id' => request('user_id'), 'answer_id' => request('answer_id')];

        if (Rate::where($match)) {
            $rate = Rate::where($match)
                ->update(['type' => request('type')]);
            return $rate;
        }
        else{
            $rate = Rate::create([
                'type'=> request('type'),
                'user_id' => request('user_id'),
                'answer_id' => request('answer_id')
            ]);
            return $rate;
        }

    }

}


