<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use App\Models\Article;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [
            url('/taiwanlottery'),
            url('/taiwanlottery/539'),
            url('/taiwanlottery/lotto'),
            url('/taiwanlottery/articles'),
        ];

        // 動態加上文章頁面
        $articles = Article::all();
        foreach ($articles as $article) {
            $urls[] = url('/taiwanlottery/article/' . $article->slug);
        }

        $xml = view('sitemap.xml', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
