<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;

class PostController extends Controller
{
    public function index()
    {

        $posts = Post::orderBy("created_at","desc")->paginate(6);
        return view('posts.index', compact('posts')); // `welcome` shabloniga o'tish
    }
    public function create()
    {
        if (Auth::check() && Auth::user()->email_verified_at == null) {
            abort(403);
        }
        return view('posts.create');
    }

    public function store(PostStoreRequest $request)
    {
        $post = new Post();
        $post->user_id = Auth::id();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        $uploadedImage = $this->uploadImage($request->file('image'));
        $post->image()->create(['path' => $uploadedImage]);

        return redirect()->route('my_profile');
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        if (Auth::id() !== $post->user_id) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }

    public function update(PostUpdateRequest $request, $id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id != Auth::id()) {
            abort(403);
        }

        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();

        if ($request->hasFile('image')) {
            if ($post->image->path) {
                $this->deleteImage($post->image->path);
            }
            $updatedImage = $this->uploadImage($request->file('image'));
            $post->image()->update(['path' => $updatedImage]);
        }

        return redirect()->route('posts.show', $post->id);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ($post->user_id != Auth::id()) {
            abort(403);
        }

        $this->deleteImage($post->image->path);
        $post->delete();

        return redirect()->route('my_profile');
    }

    protected function uploadImage($image)
    {
        $imagePath = time() . "." . $image->getClientOriginalExtension();
        return $image->storeAs('uploads', $imagePath, 'public');
    }

    protected function deleteImage($path)
    {
        @unlink(storage_path('app/public/' . $path));
    }

    public function userProfile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('user.user_profile', compact('user'));
    }
}
