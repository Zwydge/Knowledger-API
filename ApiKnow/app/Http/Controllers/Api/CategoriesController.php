<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Category;
use App\Reputation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CategoriesController extends Controller
{

    public function get(Request $request){

        $category = Category::orderBy('name')
            ->get();

        return response()->json(['data'=>$category],200, [], JSON_NUMERIC_CHECK);
    }

    public function userrep(Request $request){

        $userrep = Reputation::where('user_id',request('user_id'))
            ->get();
        $rep_list = array();
        $i = 0;
        foreach ($userrep as $cat){
            $rep_list[$i]['id'] = $cat['id'];
            $rep_list[$i]['user_id'] = $cat['user_id'];
            $rep_list[$i]['value'] = $cat['value'];

            $name = Category::where(['id' => $cat['category_id']])
                ->get();

            $rep_list[$i]['category'] = $name[0]['name'];
            $i++;
        }

        return response()->json(['data'=>$rep_list],200, [], JSON_NUMERIC_CHECK);
    }

    public function member(Request $request){

        $count = Reputation::where(['category_id' => request('category_id')])
                ->count(DB::raw('DISTINCT user_id'));

        return response()->json(['data'=>$count],200, [], JSON_NUMERIC_CHECK);
    }

    public function allmember(Request $request){

        $cat = Category::orderBy('name')
            ->get();
        $i = 0;
        $cat_list = array();
        foreach ($cat as $category){
            $cat_list[$i]['name'] = $category['name'];

            $count = Reputation::where(['category_id' => $category['id']])
                ->count(DB::raw('DISTINCT user_id'));

            $cat_list[$i]['member'] = $count;
            $i++;
        }

        return response()->json(['data'=>$cat_list],200, [], JSON_NUMERIC_CHECK);
    }

    public function create(Request $request){

        $category = Category::create([
            'name'=> request('name')
        ]);

        return $category;

    }

    public function delete(Request $request){

        $category = Category::findOrFail(request('category_id'));
        $category->delete();

        return 'success';

    }

}


