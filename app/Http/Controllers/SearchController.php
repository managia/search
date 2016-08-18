<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function search(Request $request)
    {
        $suggests = [];
        $error = '';
        $search = $request->get('data');
        $params = $request->get('params');
        if ($params) {
            $suggests = Question::where('question', 'like', '%' . $params['keywords'] . '%')->take(10)->get();
            /* @var $suggests \Illuminate\Database\Eloquent\Collection */
            return response()->json(
                            ['keywords' => $suggests->pluck('question')]
            );
        } elseif ($search) {
            $suggests = Question::where('question', 'like', '%' . $search . '%')->take(10)->get();
        } else {
            $error = 'Empty string';
        }
        return response()->json(compact('suggests', 'error'));
    }

    public function showSearch()
    {
        $config = json_encode([
            'timeout' => env('QUESTION_TIMEOUT'),
            'minimum_length' => env('QUESTION_MINIMUM_LENGTH'),
        ]);
        return view('welcome', compact('config'));
    }

}
