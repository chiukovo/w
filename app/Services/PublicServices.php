<?php

namespace App\Services;

use App\Models\Transform;
use DB, Storage, Curl;

class PublicServices
{
    public static function AddTransForm()
    {
        for ($i = 1; $i < 10; $i++) { 
            $url = 'https://api-lineagew.plaync.com/search/polymorphs?locale=zh-TW&page='.$i.'&size=10000&favorite=false';

            $result = Curl::to($url)->asJson(true)->get();

            if (isset($result['contents']) && !empty($result['contents'])) {
                foreach ($result['contents'] as $data) {
                    Transform::firstOrCreate(['t_id' => $data['id']], [
                        't_id' => $data['id'],
                        'name' => $data['name'],
                        'image' => $data['image'],
                        'gradeId' => $data['gradeId'],
                        'weaponTypeList' => json_encode($data['weaponTypeList'], JSON_UNESCAPED_UNICODE),
                        'buffBonusList' => json_encode($data['buffBonusList'], JSON_UNESCAPED_UNICODE),
                    ]);
                }
            }

            if (empty($result['contents'])) {
                break;
            }
        }

        echo 'done';
    }
}