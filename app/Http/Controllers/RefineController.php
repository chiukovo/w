<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RefineController extends Controller
{
    // 精煉初始化（同時清除所有 refine_* session）
    public function init(Request $request)
    {
        $ip = getClientIp();
        $nickname = $request->input('nickname');
        if (!$nickname) {
            return response()->json(['message' => '暱稱必填'], 422);
        }
        $sessionKey = "refine_{$nickname}_{$ip}";
        // 只清除該暱稱+IP相關 session
        foreach (session()->all() as $key => $val) {
            if ($key === $sessionKey) {
                session()->forget($key);
            }
        }
        session([$sessionKey => [
            'refineLevel' => 0,
            'totalCost' => 0,
            'totalRefine' => 0,
            'broken' => false,
        ]]);
        // 回傳完整狀態
        return response()->json([
            'message' => '初始化成功',
            'refineLevel' => 0,
            'totalCost' => 0,
            'totalRefine' => 0,
            'broken' => false,
        ]);
    }

    // 精煉
    public function do(Request $request)
    {
        $nickname = $request->input('nickname');
        if (!$nickname) {
            return response()->json(['message' => '暱稱必填'], 422);
        }
        $ip = getClientIp();
        $sessionKey = "refine_{$nickname}_{$ip}";
        $state = $request->session()->get($sessionKey);
        if (!$state) {
            // session 不存在就初始化
            $request->session()->put($sessionKey, [
                'refineLevel' => 0,
                'totalCost' => 0,
                'totalRefine' => 0,
                'broken' => false,
            ]);
            $state = $request->session()->get($sessionKey);
        }

        $refineLevel = $state['refineLevel'];
        $totalCost = $state['totalCost'];
        $totalRefine = $state['totalRefine'];
        $broken = $state['broken']; // 修正：broken 狀態應從 session 取
        $isMax = $refineLevel >= 15;
        $result = [
            'success' => false,
            'broken' => $broken,
            'refineLevel' => $refineLevel,
            'totalCost' => $totalCost,
            'totalRefine' => $totalRefine,
            'isMax' => $isMax,
            'msg' => '',
            'inRank' => false,
        ];
        if ($isMax || $broken) {
            $result['msg'] = $isMax ? '已達+15' : '裝備損壞，請修理';
            return response()->json($result);
        }
        $rate1 = 50;
        $rate2 = 40;
        
        $nextRefine = $refineLevel + 1;
        $successRate = $nextRefine <= 4 ? 100 : (($nextRefine === 5 || $nextRefine === 6) ? $rate1 : $rate2);
        $zenyCost = $isMax ? 0 : ($nextRefine * 10000);
        $materialCost = $isMax ? 0 : ($refineLevel >= 10 ? 100000 : 20000);
        $totalCost += $zenyCost;
        $totalRefine++;
        $roll = mt_rand(1, 100);
        if ($successRate === 100 || $roll <= $successRate) {
            $refineLevel++;
            $result['success'] = true;
            $result['refineLevel'] = $refineLevel;
            $result['msg'] = $successRate === 100 ? '精煉成功！（100%）' : "精煉成功！（{$successRate}%）";
            $result['totalCost'] = $totalCost;
            $result['totalRefine'] = $totalRefine;
            $result['broken'] = false;
            $result['isMax'] = $refineLevel >= 15;
        } else {
            $failLevel = $refineLevel + 1;
            $refineLevel = max(0, $refineLevel - 1);
            $willBreak = false;
            if ($failLevel >= 10 && $failLevel <= 14) {
                $willBreak = true;
            } elseif ($failLevel >= 4 && $failLevel <= 9) {
                $willBreak = mt_rand(0, 1) === 1;
            }
            $result['refineLevel'] = $refineLevel;
            $result['totalCost'] = $totalCost;
            $result['totalRefine'] = $totalRefine;
            if ($willBreak) {
                $result['broken'] = true;
                $result['msg'] = "精煉失敗！裝備損壞！（掉至+{$refineLevel})";
            } else {
                $result['msg'] = "精煉失敗！掉一階（+{$refineLevel}）";
            }
        }
        // 統計資料（各等級嘗試、成功、損壞次數）
        // 取出或初始化
        $stats = $state['stats'] ?? [
            'try' => array_fill(0, 16, 0),
            'pass' => array_fill(0, 16, 0),
            'broken' => array_fill(0, 16, 0),
        ];
        // 本次精煉等級
        $curLevel = $state['refineLevel'];
        // 統計：每次嘗試
        if ($curLevel >= 0 && $curLevel < 15) {
            $stats['try'][$curLevel + 1]++;
        }
        // 統計：成功
        if ($result['success'] && $curLevel >= 0 && $curLevel < 15) {
            $stats['pass'][$curLevel + 1]++;
        }
        // 統計：損壞
        if (isset($result['broken']) && $result['broken'] && $curLevel >= 0 && $curLevel < 15) {
            $stats['broken'][$curLevel + 1]++;
        }
        // 更新 session 狀態（修正：broken 也要存）
        session([$sessionKey => [
            'refineLevel' => $result['refineLevel'],
            'totalCost' => $result['totalCost'],
            'totalRefine' => $result['totalRefine'],
            'broken' => $result['broken'],
            'stats' => $stats,
        ]]);
        // 回傳統計資料給前端
        $result['stats'] = $stats;
        // 達到+15自動進排行榜
        if ($result['isMax']) {
            // 允許重複進榜：每次從+14升+15都記錄
            if ($state['refineLevel'] === 14 && $result['refineLevel'] === 15) {
                DB::table('refine_rankings')->insert([
                    'nickname' => $nickname,
                    'refine_count' => $totalRefine,
                    'total_cost' => $totalCost,
                    'achieved_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $result['inRank'] = true;
                // ou排行：精煉次數最少（升冪）
                $ouRank = DB::table('refine_rankings')
                    ->where('refine_count', '<', $totalRefine)
                    ->count();
                $result['ou_rank'] = $ouRank + 1;
                // hei排行：精煉次數最多（降冪）
                $heiRank = DB::table('refine_rankings')
                    ->where('refine_count', '>', $totalRefine)
                    ->count();
                $result['hei_rank'] = $heiRank + 1;
            }
        }
        // 頻率限制：每個 session 1 秒最多 2 次
        $now = microtime(true);
        $lastRefineTime = $state['lastRefineTime'] ?? 0;
        if ($now - $lastRefineTime < 0.5) {
            return response()->json(['message' => '請勿過於頻繁操作，請稍後再試'], 429);
        }
        $state['lastRefineTime'] = $now;
        return response()->json($result);
    }

    // 精煉（路由用 doRefine，實際方法名為 do）
    public function doRefine(Request $request)
    {
        return $this->do($request);
    }

    // 排行榜儲存（如有需要）
    public function rank(Request $request)
    {
        $nickname = $request->input('nickname');
        $refine_count = $request->input('refine_count');
        if (!$nickname || !$refine_count) {
            return response()->json(['message' => '暱稱與精煉次數必填'], 422);
        }
        DB::table('refine_rankings')->insert([
            'nickname' => $nickname,
            'refine_count' => $refine_count,
            'total_cost' => $request->input('total_cost', 0),
            'achieved_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json(['message' => '儲存成功']);
    }

    // 排行榜查詢
    public function rankings()
    {
        $ou = DB::table('refine_rankings')->orderBy('refine_count')->orderBy('achieved_at')->limit(10)->get(['nickname','refine_count','total_cost']);
        $hei = DB::table('refine_rankings')->orderByDesc('refine_count')->orderBy('achieved_at')->limit(10)->get(['nickname','refine_count','total_cost']);
        return response()->json([
            'ou' => $ou,
            'hei' => $hei,
        ]);
    }

    // 修理API
    public function repair(Request $request)
    {
        $nickname = $request->input('nickname');
        if (!$nickname) {
            return response()->json(['message' => '暱稱必填'], 422);
        }
        $ip = getClientIp();
        $sessionKey = "refine_{$nickname}_{$ip}";
        $state = $request->session()->get($sessionKey);
        if (!$state) {
            // session 不存在就初始化
            $request->session()->put($sessionKey, [
                'refineLevel' => 0,
                'totalCost' => 0,
                'totalRefine' => 0,
                'broken' => false,
            ]);
            $state = $request->session()->get($sessionKey);
        }
        $repairCost = $request->input('repairCost', 2000000); // 預設200萬
        $state['totalCost'] = ($state['totalCost'] ?? 0) + intval($repairCost);
        $state['broken'] = false;
        session([$sessionKey => $state]);
        return response()->json([
            'message' => '裝備已修理，可再次精煉！',
            'refineLevel' => $state['refineLevel'],
            'totalCost' => $state['totalCost'],
            'totalRefine' => $state['totalRefine'],
            'broken' => false,
        ]);
    }
}
