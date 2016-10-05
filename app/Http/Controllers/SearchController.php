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
        $suggests = [];
        $error = '';
        $categories = $request->get('categories');
        $keywords = $request->get('keywords');
        
        $keywordsExplode = $this->explodeString($keywords);
        
        if (!empty($keywordsExplode)) {
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
            } elseif ($categories == 'none') {
                $queryQuestion->where(function ($query) {
                    $queryQuestion->whereNull('category_id');
                    $queryQuestion->orWhere('category_id', 0);
                });
                $queryAnswer->where(function ($query) {
                    $queryAnswer->whereNull('category_id');
                    $queryAnswer->orWhere('category_id', 0);
                });
            }
            $suggests = $queryQuestion->take(10)->get();
            $suggestsTwo = $queryAnswer->take(10)->get();
        } else {
            $error = 'Empty string';
        }
        
        return response()
                        ->json(compact('suggests', 'error', 'categories'))
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
