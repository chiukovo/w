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
        $category = Request::get('category'); // 抓取篩選參數
    
        // 取出不重複的分類
        $categories = Article::select('category')->distinct()->pluck('category')->toArray();
    
        // 如果有分類篩選，就加 where
        $query = Article::orderBy('published_at', 'desc');
        if ($category) {
            $query->where('category', $category);
        }
    
        $articles = $query->paginate(10)->toArray();
    
        return view('taiwanlottery/articles', [
            'articles' => $articles,
            'categories' => $categories,
            'currentCategory' => $category
        ]);
    }
    

    public function articlesDetail($slug)
    {
        $article = Article::where('slug', $slug)->first();
        if (!$article) {
            $article = Article::inRandomOrder()->first()->toArray();
        } else {
            $article = $article->toArray();
        }
    
        $relatedArticles = Article::where('category', $article['category'])
            ->where('id', '!=', $article['id'])
            ->inRandomOrder()
            ->limit(4)
            ->get();
    
        return view('taiwanlottery/articleDetail', [
            'article' => $article,
            'relatedArticles' => $relatedArticles
        ]);
    }
    
}