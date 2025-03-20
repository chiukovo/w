<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use App\Models\Article;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = collect([
            ['loc' => url('/'), 'lastmod' => now()->toAtomString()],
            ['loc' => url('/taiwanlottery/539'), 'lastmod' => now()->toAtomString()],
            ['loc' => url('/taiwanlottery/lotto'), 'lastmod' => now()->toAtomString()],
            ['loc' => url('/taiwanlottery/articles'), 'lastmod' => now()->toAtomString()],
        ]);
    
        $articles = Article::all();
        foreach ($articles as $article) {
            $urls->push([
                'loc' => url('/taiwanlottery/article/' . $article->slug),
                'lastmod' => optional($article->updated_at)->toAtomString() ?? now()->toAtomString()
            ]);
        }
    
        $xml = view('sitemap.xml', ['urls' => $urls])->render();
        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
