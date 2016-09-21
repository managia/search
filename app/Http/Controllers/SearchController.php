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
     * Search action
     * @param Request $request
     * @return string
     */
    public function search(Request $request)
    {
        $suggests = [];
        $error = '';
        $categories = $request->get('categories');
        $keywords = $request->get('keywords');
        if ($keywords) {
            /* @var $query ClassName */
            $query = (new Question())->query();
            $query->where('question', 'like', '%' . $keywords . '%');
            if (is_numeric($categories)) {
                $query->where('category_id', $categories);
            } elseif ($categories == 'none') {
                $query->where(function ($query) {
                    $query->whereNull('category_id');
                    $query->orWhere('category_id', 0);
                });
            }
            $suggests = $query->take(10)->get();
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

}
