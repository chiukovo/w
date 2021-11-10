<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transform extends Model
{
    use HasFactory;

    protected $table = 'transform';
    protected $guarded = [];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function probability()
    {
        return $this->hasOne(Probability::class, 'gradeId', 'gradeId');
    }
}