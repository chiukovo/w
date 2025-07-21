<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // 取得留言列表
    public function index()
    {
        $comments = Comment::orderBy('id', 'desc')->limit(20)->get();
        return response()->json($comments);
    }

    // 新增留言
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20', // 暱稱限20字
            'content' => 'required|string|max:200', // 內容限200字
        ]);
        $comment = Comment::create([
            'name' => $request->name,
            'content' => $request->content,
        ]);
        return response()->json($comment, 201);
    }
}
