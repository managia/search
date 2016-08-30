<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $config = json_encode([
            'timeout' => env('QUESTION_TIMEOUT'),
            'minimum_length' => env('QUESTION_MINIMUM_LENGTH'),
        ]);
        $keyword = $request->cookie('keywords', '');
        $category = $request->cookie('categories', '');
        $categories = [
            'all' => 'Все категории',
            'none' => 'Категория не присвоена'
                ] + Category::all()->pluck('name', 'id')->toArray();
        return view('home'
                , compact('config', 'categories', 'keyword', 'category')
        );
    }
}
