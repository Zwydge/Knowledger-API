<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Question;
use App\Reputation;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UsersController extends Controller
{

    public function get(Request $request){

        $user = User::orderBy('id', 'desc')
            ->get();

        return Response::json($user);
    }

    public function quest(){

        $userId = Auth::id();

        $category = Reputation::where('user_id', $userId)
            ->get('category_id');

        $quest_list = array();
        $i = 0;

        foreach ($category as $cat){
            $content = Question::where('category_id', $cat['category_id'])
                ->get();
            $cat_name = Category::where('id', $cat['category_id'])->get('name');
            foreach ($content as $cont){
                $quest_list[$i]['category'] = $cat_name[0]['name'];
                $quest_list[$i]['content'] = $cont['content'];
                $quest_list[$i]['id'] = $cont['id'];
                $i++;
            }
        }

        return response()->json(['data'=>$quest_list],200, [], JSON_NUMERIC_CHECK);

    }

    public function informations(Request $request){

        $userId = Auth::id();

        $user = User::where('id',$userId)
            ->get();

        return response()->json(['data'=>$user],200, [], JSON_NUMERIC_CHECK);
    }

    public function cat(Request $request){

        $rep = Reputation::where('user_id', request('user_id'))
            ->orderBy('id', 'desc')
            ->get();

        $cat_list = array();

        foreach ($rep as $repp){
            $cat = Category::findOrFail(request($repp['categry_id']));
            array_push($cat_list, $cat[0]['id']);
        }

        return Response::json($cat_list);
    }


    public function rep(Request $request){

        $match = ['user_id' => request('user_id'), 'category_id' => request('category_id')];

        $rep = Reputation::where($match)
            ->get();

        return Response::json($rep[0]['value']);
    }


    public function delete(Request $request){

        $user = User::findOrFail(request('user_id'));
        $user->delete();

        return 'success';

    }

}
