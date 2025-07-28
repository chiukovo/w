<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RefineRanking;
use Illuminate\Support\Facades\DB;

class InjectFakeRefineRankings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refine:inject-fake-rankings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '注入一組模仿遊戲暱稱的精煉排行榜假資料';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faker = [
            // 臉黑排行（精煉次數多，總花費高，約90~180次）
            ['nickname' => '非洲大酋長zzzz', 'refine_count' => 180, 'total_cost' => 36000000],
            ['nickname' => '安精王', 'refine_count' => 165, 'total_cost' => 33000000],
            ['nickname' => '紅垂哥=_=', 'refine_count' => 150, 'total_cost' => 30000000],
            ['nickname' => 'O_o~~~~', 'refine_count' => 140, 'total_cost' => 28000000],
        
        ];

        $now = now();
        foreach ($faker as $row) {
            // 避免重複注入
            if (!RefineRanking::where('nickname', $row['nickname'])->exists()) {
                RefineRanking::create([
                    'nickname' => $row['nickname'],
                    'refine_count' => $row['refine_count'],
                    'total_cost' => $row['total_cost'],
                    'achieved_at' => $now,
                ]);
            }
        }
        $this->info('假排行榜資料已注入！');
    }
}
