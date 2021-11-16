<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecordDetail extends Model
{
    use HasFactory;

    protected $table = 'record_detail';
    protected $guarded = [];

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    
    public function transform()
    {
        return $this->hasOne(Transform::class, 't_id', 't_id');
    }
}