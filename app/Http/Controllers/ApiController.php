<?php

namespace App\Http\Controllers;

use App\Models\Transform;
use App\Models\Probability;
use Request, Storage;

class ApiController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function rate()
    {
        $rate = Probability::where('probability', '!=', 0)->get(['name', 'gradeId', 'probability'])->toArray();

        foreach($rate as $key => $data) {
            $rate[$key]['count'] = 0;
            $rate[$key]['myProbability'] = 0;
        }

        return $rate;
    }

    public function lottery()
    {
        $allTransform = Transform::with(['probability'])
            ->where('gradeId', '!=', 5)
            ->get()
            ->toArray();

        $probability = Probability::get(['name', 'gradeId', 'probability'])->toArray();

        $result = [];
        $ranges = [];
        $maxNum = 0;
        $generally = 0;
        $grade = 0;
        $rare = 0;
        $hero = 0;

        foreach ($probability as $data) {
            if ($data['probability'] > 0) {
                $computedNum = (float)($data['probability'] * 10000);
                $ranges[] = [
                    'gradeId' => $data['gradeId'],
                    'source' => $data['probability'],
                    'probability' => $computedNum,
                ];

                if ($computedNum > $maxNum) {
                    $maxNum = $computedNum;
                }
            }
        }

        //抽11次
        $total = 11;
        for ($num = 1; $num <= 11; $num++) {
            $gradeId = '';
            $randNum = rand(1, $maxNum);
            
            //看看範圍
            foreach ($ranges as $key => $range) {
                if (!isset($ranges[$key - 1])) {
                    if ($randNum >= 1 && $randNum <= $range['probability']) {
                        $gradeId = $range['gradeId'];
                    }
                } else {
                    $start = $ranges[$key - 1]['probability'] + 1;
                    $end = $range['probability'];
                    if ($randNum > $start && $randNum <= $end) {
                        $gradeId = $range['gradeId'];
                    }
                }
            }
            
            //找怪
            $findTransform = [];

            foreach ($allTransform as $transform) {
                if ($transform['gradeId'] == $gradeId) {
                    $findTransform[] = $transform;
                }
            }

            //在隨機一個
            $countFindData = count($findTransform);
            $randKey = rand(0, $countFindData - 1);
            $randData = $findTransform[$randKey];

            switch ($randData['gradeId']) {
                case 1:
                    $generally++;
                    break;
                case 2:
                    $grade++;
                    break;
                case 3:
                    $rare++;
                    break;
                   case 4:
                    $hero++;
                    break;
            }

            $result[] = [
                'name' => $randData['name'],
                'gradeId' => $randData['gradeId'],
                'image' => $randData['image'],
                'weaponTypeList' => json_decode($randData['weaponTypeList'], true),
                'buffBonusList' => json_decode($randData['buffBonusList'], true),
                'p_name' => $randData['probability']['name'],
                'flip' => false,
            ];
        }

        return [
            'data' => $result,
            'generally' => $generally,
            'grade' => $grade,
            'rare' => $rare,
            'hero' => $hero
        ];
    }
}