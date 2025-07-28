<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefineRanking extends Model
{
    use HasFactory;
    protected $table = 'refine_rankings';
    protected $fillable = [
        'nickname',
        'refine_count',
        'total_cost',
        'achieved_at',
    ];
}
