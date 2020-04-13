<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class QuestionsController extends Controller
{

    public function get(Request $request){

        $question = Question::where('category_id', request('category_id'))
            ->orderBy('id', 'desc')
            ->get();

        return Response::json($question);

    }


    public function ask(Request $request){

        $question = Question::create([
            'content'=> request('content'),
            'user_id' => request('user_id'),
            'category_id' => request('category_id')
        ]);

        return $question;

    }

    public function delete(Request $request){

        $question = Question::findOrFail(request('question_id'));
        $question->delete();

        return 'success';

    }
}
