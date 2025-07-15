<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Reply;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        Comment::create([
            'post_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->input('comment'),    
        ]);

        return redirect()->back()->with('open_comment', true);
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required',
        ]);

        Reply::create([
            'comment_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->input('reply'),
        ]);

        return redirect()->back()->with('open_comment', true);
    }

    public function destroy($id)
    {

        $comment = Comment::findOrFail($id);

        $comment->delete();

        $keepOpen = request()->query('keep_comment') === '1';
        return redirect()->back()->with('open_comment', $keepOpen);
    }
}
