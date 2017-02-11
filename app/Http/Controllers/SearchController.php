<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Search action from questions
     * @param Request $request
     * @return string
     * 
     */
    public function search(Request $request)
    {
        $numQuestion = 10;
        $numPopular = 7;
        
        $suggests = [];
        $error = '';
        $categories = $request->get('categories');
        $keywords = $request->get('keywords');
        
        $keywordsExplode = $this->explodeString($keywords);
        
        if (!empty($keywordsExplode)) {
            // Popular answers
            $popularAnswer   = (new Question())->query()->where('popular', '=', 1);
            /* @var $queryQuestion ClassName */
            /* @var $queryAnswer   ClassName */
            $queryQuestion = (new Question())->query();
            $queryAnswer   = (new Question())->query();
            foreach($keywordsExplode as $keyword){
              $queryQuestion->where('question', 'like', '%' . $keyword . '%');
              $queryAnswer->where('answer', 'like', '%' . $keyword . '%');
            }
            if (is_numeric($categories)) {
              $queryQuestion->where('category_id', $categories);
              $queryAnswer->where('category_id', $categories);
              $popularAnswer->where('category_id', $categories);
            } elseif ($categories == 'none') {
                $queryQuestion->where(function ($query) {
                    $queryQuestion->whereNull('category_id');
                    $queryQuestion->orWhere('category_id', 0);
                });
                $queryAnswer->where(function ($query) {
                    $queryAnswer->whereNull('category_id');
                    $queryAnswer->orWhere('category_id', 0);
                });
                $popularAnswer->where(function ($query) {
                    $popularAnswer->whereNull('category_id');
                    $popularAnswer->orWhere('category_id', 0);
                });
            }
            $popular = $popularAnswer->take($numPopular)->get();
            $suggestsQuestion = $queryQuestion->take($numQuestion)->get();
            $suggestsAnswer = $queryAnswer->take($numQuestion)->get();
            $suggests = $suggestsQuestion->merge($suggestsAnswer);
        } else {
            $error = 'Empty string';
        }
        
        return response()
                        ->json(compact('suggests', 'popular', 'error', 'categories'))
                        ->withCookie(
                                cookie('keywords', $keywords, 45000)
                        )
                        ->withCookie(
                                cookie('categories', $categories, 45000)
        );
    }

    //*
    //* Метод разбивает строку на слова
    //*
    private function explodeString($string)
    {
        $keywords = explode(" ", $string);
        return $keywords;
    }


}
