<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommentController extends Controller
{
    // 取得留言列表
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 5;
        
        $comments = Comment::orderBy('id', 'desc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();
            
        $total = Comment::count();
        $hasMore = ($page * $perPage) < $total;
        
        return response()->json([
            'data' => $comments,
            'total' => $total,
            'has_more' => $hasMore,
            'current_page' => $page
        ]);
    }

    // 新增留言
    public function store(Request $request)
    {
        // 取得客戶端 IP
        $clientIp = $this->getClientIp($request);
        
        // 檢查該 IP 是否在 5 秒內已經新增過留言
        $cacheKey = 'comment_rate_limit_' . $clientIp;
        if (Cache::has($cacheKey)) {
            return response()->json([
                'message' => '請勿頻繁留言，請等待 5 秒後再試'
            ], 429);
        }

        $request->validate([
            'name' => 'required|string|max:20', // 暱稱限20字
            'content' => 'required|string|max:200', // 內容限200字
        ]);
        
        $comment = Comment::create([
            'name' => $request->name,
            'content' => $request->content,
        ]);

        // 設定該 IP 的限制，5 秒後過期
        Cache::put($cacheKey, true, 5);

        return response()->json($comment, 201);
    }

    /**
     * 取得客戶端真實 IP
     */
    private function getClientIp(Request $request)
    {
        $ipKeys = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                $ip = $_SERVER[$key];
                if (strpos($ip, ',') !== false) {
                    $ip = explode(',', $ip)[0];
                }
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }

        return $request->ip();
    }
}
