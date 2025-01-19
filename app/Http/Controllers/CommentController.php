<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'comment' => 'required|string|max:500',
        ]);
    
        Comment::create([
            'user_id' => Auth::id(),
            'article_id' => $request->article_id,
            'comment' => $request->comment,
            'comment_id' => $request->comment_id,
        ]);
    
        return redirect()->back()->with('status', 'Komentar berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        Comment::where('id', $id)->orWhere('comment_id', $id)->delete();

        return redirect()->back()->with('status', 'Komentar berhasil dihapus.');
    }
}