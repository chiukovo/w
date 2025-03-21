<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Article;
use App\Models\Bets;
use Illuminate\Support\Facades\RateLimiter;
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
    
    public function bets($type)
    {
        $betCount = request()->input('betCount');
        $userId = auth()->user()->id ?? 0;
        $ip = getClientIp();
        $key = 'bets:' . $ip;

        if (!RateLimiter::remaining($key, 1)) {
            return response()->json(['error' => '每 3 秒僅能下注一次，請稍後再試'], 429);
        }
    
        // 記錄這次請求，3秒過期
        RateLimiter::hit($key, 3);
        
        // 依據 type 決定開獎規則
        switch ($type) {
            case 'power': // 威力彩
                $mainRange = range(1, 38);
                $mainCount = 6;
                $secondaryRange = range(1, 8);
                $hasSecondary = true;
                break;
            case 'lotto': // 大樂透
                $mainRange = range(1, 49);
                $secondaryRange = range(1, 49);
                $mainCount = 6;
                $hasSecondary = true;
                break;
            case '539': // 今彩539
                $mainRange = range(1, 39);
                $mainCount = 5;
                $hasSecondary = false;
                break;
            default:
                return response()->json(['error' => '無效的遊戲類型'], 400);
        }
    
        $mainNumbers = request()->input('mainNumbers');
        $secondaryNumber = $hasSecondary ? request()->input('secondaryNumber') : null;
        
        // 安全性檢查 (簡單檢查)
        if (count($mainNumbers) !== $mainCount || (array_diff($mainNumbers, $mainRange))) {
            return response()->json(['error' => '開獎號碼不正確'], 400);
        }
        if ($hasSecondary && !in_array($secondaryNumber, $secondaryRange)) {
            return response()->json(['error' => '第二區號碼不正確'], 400);
        }
    
        $totalWinnings = 0;
        $prizeCount = [];
        $winningHistory = [];
        $history = [];
    
        for ($i = 0; $i < $betCount; $i++) {
            $ticket = collect($mainRange)->random($mainCount)->sort()->values()->toArray();
            $secondary = $hasSecondary ? rand(min($secondaryRange), max($secondaryRange)) : null;
    
            [$prizeName, $amount] = $this->calculatePrize($type, $ticket, $secondary, $mainNumbers, $secondaryNumber);
            $totalWinnings += $amount;
            $prizeCount[$prizeName] = ($prizeCount[$prizeName] ?? 0) + 1;
    
            $entry = [
                'id' => $i + 1,
                'numbers' => $ticket,
                'secondary' => $secondary,
                'prize' => $amount,
                'prizeName' => $prizeName
            ];
    
            if ($amount > 0) {
                $winningHistory[] = $entry;
            }

            $text = "第 " . ($i + 1) . " 注: " . implode(', ', $ticket);
            if ($hasSecondary) {
                $text .= " + {$secondary}";
            }
            $history[] = ['id' => $i + 1, 'text' => $text];
        }
    
        // 存入資料庫
        if ($userId) {
            Bets::create([
                'user_id' => $userId,
                'game' => $type,
                'bet_count' => $betCount,
                'total_cost' => $betCount * 100,
                'total_win' => $totalWinnings,
                'net_profit' => $totalWinnings - ($betCount * 100),
            ]);
        }
    
        return response()->json([
            'mainNumbers' => $mainNumbers,
            'secondaryNumber' => $secondaryNumber,
            'totalWinnings' => $totalWinnings,
            'prizeCount' => $prizeCount,
            'totalCost' => $betCount * 100,
            'netProfit' => $totalWinnings - ($betCount * 100),
            'winningHistory' => $winningHistory,
            'history' => $history,
            'totalBets' => $betCount,
        ]);
    }
    
    
    private function calculatePrize($type, $ticket, $secondary, $mainNumbers, $secondaryNumber)
    {
        $match = count(array_intersect($ticket, $mainNumbers));
        $secMatch = $secondary === $secondaryNumber;
    
        // 威力彩獎項
        if ($type === 'power') {
            if ($match === 6 && $secMatch) return ['頭獎', 1000000000];
            if ($match === 6) return ['貳獎', 2000000];
            if ($match === 5 && $secMatch) return ['參獎', 150000];
            if ($match === 5) return ['肆獎', 20000];
            if ($match === 4 && $secMatch) return ['伍獎', 4000];
            if ($match === 4) return ['陸獎', 800];
            if ($match === 3 && $secMatch) return ['柒獎', 400];
            if ($match === 2 && $secMatch) return ['捌獎', 200];
            if ($match === 3) return ['玖獎', 100];
            if ($match === 1 && $secMatch) return ['普獎', 100];
            return ['未中獎', 0];
        }
    
        // 大樂透獎項 (含特別號)
        if ($type === 'lotto') {
            if ($match === 6) return ['頭獎', 80000000];
            if ($match === 5 && $secMatch) return ['貳獎', 1000000];
            if ($match === 5) return ['參獎', 50000];
            if ($match === 4 && $secMatch) return ['肆獎', 5000];
            if ($match === 4) return ['伍獎', 2000];
            if ($match === 3 && $secMatch) return ['陸獎', 1000];
            if ($match === 2 && $secMatch) return ['柒獎', 400];
            if ($match === 3) return ['普獎', 400];
            return ['未中獎', 0];
        }

        if ($type === '539') {
            if ($match === 5) return ['頭獎', 8000000];
            if ($match === 4) return ['貳獎', 2000];
            if ($match === 3) return ['參獎', 300];
            if ($match === 2) return ['肆獎', 50];
            return ['未中獎', 0];
        }
    
        return ['未中獎', 0];
    }
}