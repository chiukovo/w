<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Request, Storage, Response, Hash, Auth, DB;

class TaiwanlotteryController extends Controller
{
    public function index()
    {
        return view('taiwanlottery/index');
    }

    public function lotto()
    {
        return view('taiwanlottery/lotto');
    }

    public function fivethreenine()
    {
        return view('taiwanlottery/539');
    }
}