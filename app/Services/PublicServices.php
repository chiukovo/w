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
                    $filePath = '/img/cards/' . $data['id'] . '.jpg';

                    if (!file_exists(public_path() . $filePath)) {
                        if ($data['image'] != '') {
                            $fileContent = file_get_contents($data['image']);
                            Storage::disk('public_cards')->put($data['id'] . '.jpg', $fileContent);
                        }
                    }

                    if ($data['image'] == '') {
                        $filePath = '';
                    }
                    
                    Transform::firstOrCreate(['t_id' => $data['id']], [
                        't_id' => $data['id'],
                        'name' => $data['name'],
                        'image' => $filePath,
                        'gradeId' => $data['gradeId'],
                        'weaponTypeList' => json_encode($data['weaponTypeList'], JSON_UNESCAPED_UNICODE),
                        'buffBonusList' => json_encode($data['buffBonusList'], JSON_UNESCAPED_UNICODE),
                    ]);

                    //update
                    Transform::where('t_id', $data['id'])
                        ->update([
                            'name' => $data['name'],
                            'image' => $filePath,
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