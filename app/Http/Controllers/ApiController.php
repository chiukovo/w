<?php

namespace App\Http\Controllers;

use App\Models\Transform;
use App\Models\Probability;
use App\Models\Users;
use App\Models\Records;
use App\Models\RecordDetail;
use Illuminate\Support\Facades\Validator;
use Request, Storage, Response, Hash, Auth, DB;

class ApiController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function test()
    {
        return view('test');
    }

    public function login()
    {
        $postData = Request::input();
        $user = auth()->user();

        if (!is_null($user)) {
            return response(['message' => '您已登入 請先登出'], 422);
        }

        $validated = Request::validate([
            'account' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        //登入
        $credentials = [
            'account' => $postData['account'],
            'password' => $postData['password'],
        ];

        if (Auth::attempt($credentials)) {
            Request::session()->regenerate();

            return [
                'message' => 'success'
            ];
        }

        return response(['message' => '帳號或密碼錯誤'], 422);
    }
    
    public function user()
    {
        $user = auth()->user();

        if (is_null($user)) {
            return response(['message' => '尚未登入'], 422);
        }

        return [
            'account' => $user->account,
            'nickname' => $user->nickname,
            'created_at' => $user->created_at,
        ];
    }

    public function logout()
    {
        auth()->logout();
    }

    public function signIn()
    {
        $postData = Request::input();
        $user = auth()->user();
        $ip = getClientIp();

        if (!is_null($user)) {
            return response(['message' => '您已登入 請先登出'], 422);
        }

        $validated = Request::validate([
            'account' => ['required', 'string', 'min:2', 'max:11'],
            'nickname' => ['required', 'string', 'min:2', 'max:11'],
            'password' => ['required', 'string', 'min:2', 'max:11', 'confirmed'],
        ]);

        //檢查此ip是否註冊過多
        $countIp = Users::where('ip', $postData['ip'])->count();

        if ($countIp > 20) {
            return response(['message' => '住手! 註冊太多帳號了吧'], 422);
        }

        //判斷是否帳號重覆
        $countAccount = Users::where('account', $postData['account'])->count();
        
        if ($countAccount) {
            return response(['message' => '此帳號已存在'], 422);
        }

        //判斷是否暱稱重覆
        $countNickName = Users::where('nickname', $postData['nickname'])->count();

        if ($countNickName) {
            return response(['message' => '此暱稱已存在'], 422);
        }

        Users::create([
            'account' => $postData['account'],
            'nickname' => $postData['nickname'],
            'ip' => getClientIp(),
            'password' => Hash::make($postData['password']),
        ]);


        //並登入
        $credentials = [
            'account' => $postData['account'],
            'password' => $postData['password'],
        ];

        if (Auth::attempt($credentials)) {
            Request::session()->regenerate();

            return [
                'message' => 'success',
            ];
        }

        return response(['message' => 'error'], 422);
    }

    public function rate()
    {
        $rate = Probability::where('probability', '!=', 0)->get(['name', 'gradeId', 'probability'])->toArray();

        //如果有登入
        $user = auth()->user();
        $date = date('Y-m-d');
        $count = 0;
        $record = [];

        if (!is_null($user)) {
            $countData = Records::where('account', $user->account)
                ->where('date', $date)
                ->first();

            if (!is_null($countData)) {
                $record = $countData->toArray();
            }
        }

        foreach($rate as $key => $data) {
            $rate[$key]['count'] = 0;
            $rate[$key]['myProbability'] = 0;

            if (!empty($record)) {
                if (isset($record['g_' . $data['gradeId']])) {
                    $rate[$key]['count'] = $record['g_' . $data['gradeId']];
                }

                $count = $record['count'];
                
                $rate[$key]['myProbability'] = number_format(($rate[$key]['count'] / ($count * 11)) * 100, 4);
            }
        }

        return [
            'data' => $rate,
            'count' => $count,
        ];
    }

    public function lottery()
    {
        usleep(500000);

        $user = auth()->user();
        $date = date('Y-m-d');
        
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
            
            if ($countFindData > 0) {
                $randKey = rand(0, $countFindData - 1);
                $randData = $findTransform[$randKey];
            } else {
                $randData = $allTransform[0];
            }

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
                't_id' => $randData['t_id'],
                'weaponTypeList' => json_decode($randData['weaponTypeList'], true),
                'buffBonusList' => json_decode($randData['buffBonusList'], true),
                'p_name' => $randData['probability']['name'],
                'flip' => false,
            ];
        }

        //如果有登入的化要記錄
        if (!is_null($user)) {
            Records::updateOrCreate([
                'account' => $user->account,
                'date' => $date,
                'type' => 0,
            ], [
                'account' => $user->account,
                'date' => $date,
                'count' => DB::raw('count + 1'),
                'g_1' => DB::raw('g_1 + ' . $generally),
                'g_2' => DB::raw('g_2 + ' . $grade),
                'g_3' => DB::raw('g_3 + ' . $rare),
                'g_4' => DB::raw('g_4 + ' . $hero),
            ]);

            foreach ($result as $data) {
                RecordDetail::updateOrCreate([
                    'account' => $user->account,
                    'date' => $date,
                    't_id' => $data['t_id'],
                    'type' => 0,
                ], [
                    'account' => $user->account,
                    'date' => $date,
                    'gradeId' => $data['gradeId'],
                    't_id' => $data['t_id'],
                    'count' => DB::raw('count + 1'),
                ]);
            }
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