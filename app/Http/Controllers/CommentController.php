<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentStoreRequest;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{
    public function store(CommentStoreRequest $request)
    {
        $post = Post::findOrFail($request->post_id);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->comment = $request->comment;
        $comment->save();

        $user = User::findOrFail($post->user_id);
        $user->notify(new NewCommentNotification($post));
        return redirect()->route('posts.show', $post->id);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (!$comment || Auth::id() !== $comment->user_id) {
            abort(403);
        }
        $comment->delete();
        return redirect()->route('posts.show', $comment->post_id);
    }
}
