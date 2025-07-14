<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostsController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $posts = Post::with('user')->latest()->get();


        return view('home', ['posts' => $posts]);
    }

    public function showWriteForm()
    {
        return view('write');
    }

    public function blog(Request $request)
    {
        $query = Post::with(['user'])->latest();

        if ($request->has('category')) {
            $query->where('category', $request->input('category'));
        }

        $posts = $query->get();
        $postCount = $posts->count();

        return view('blog', [
            'posts' => $posts,
            'postCount' => $postCount,
        ]);
    }


    public function userPosts()
    {
        $posts = Post::where('user_id', Auth::id())->with('user')->latest()->get();
        $postCount = $posts->count();

        return view('userPosts', ['posts' => $posts]);
    }

    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('uploads', 'public');
        }

        Post::create($validated);

        return redirect()->route('userPosts.show')->with('success', 'Post created successfully!');
    }

    public function show($id)
    {
        $post = Post::with(['comments.user', 'comments.reply.user', 'likes'])->findOrFail($id);

        return view('post', ['post' => $post]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('userPosts.show')->with('success', 'Post deleted successfully.');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('edit', ['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);



        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('uploads', 'public');
        }

        $post->update($validated);

        return redirect()->route('showblog')->with('success', 'Post updated successfully!');
    }

    public function like(Post $post)
    {
        $user = Auth::user();

        $alreadyLiked = $post->likedByUser($user->id);

        if ($alreadyLiked) {
            $post->likes()->where('user_id', $user->id)->delete();
        } else {
            $post->likes()->create([
                'user_id' => $user->id
            ]);
        }


        return redirect()->back();
    }
}
