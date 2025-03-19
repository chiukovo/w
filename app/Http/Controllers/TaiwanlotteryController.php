<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use Request, Storage, Response, Hash, Auth, DB;

class TaiwanlotteryController extends Controller
{
    public function index()
    {
        return view('taiwanlottery/index');
    }

    public function lotto()
    {
        return view('taiwanlottery/lotto');
    }

    public function fivethreenine()
    {
        return view('taiwanlottery/539');
    }

    public function articlesList()
    {
        $page = Request::get('page', 1);
        $articles = Article::orderBy('published_at', 'desc')
            ->paginate(10)
            ->toArray();

        return view('taiwanlottery/articles', ['articles' => $articles]);
    }

    public function articlesDetail($slug)
    {
        $article = Article::where('slug', $slug)->first();
        //如果是空值 隨機找一個
        if (!$article) {
            $article = Article::inRandomOrder()->first()->toArray();
        } else {
            $article = $article->toArray();
        }

        return view('taiwanlottery/articleDetail', ['article' => $article]);
    }
}