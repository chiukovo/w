<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Bets extends Model
{
    use HasFactory;

    protected $table = 'bets';
    protected $guarded = [];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->hasOne(Users::class, 'id', 'user_id');
    }

    public static function getNetProfitRanking($game, $limit = 10, $userId = null)
    {
        $query = self::query()
            ->whereDate('stat_date', Carbon::today())
            ->with('user');
    
        if ($game) {
            $query->where('game', $game);
        }
    
        // 根據遊戲類型決定單價
        $pricePerBet = ($game === '威力彩') ? 100 : 50;
    
        return $query
            ->orderByRaw("CAST(total_win AS SIGNED) - CAST(bet_count * {$pricePerBet} AS SIGNED) DESC")
            ->take($limit)
            ->get()
            ->map(function ($item) use ($userId, $pricePerBet) {
                $netProfit = $item->total_win - ($item->bet_count * $pricePerBet);
    
                return [
                    'user_id'    => $item->user_id,
                    'nickname'   => $item->user->nickname,
                    'bet_count'  => number_format($item->bet_count),
                    'total_win'  => number_format($item->total_win),
                    'net_profit' => number_format($netProfit),
                    'is_me'      => $userId && $item->user_id === $userId,
                ];
            });
    }
}