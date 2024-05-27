<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $start_date = Carbon::createFromDate($request->get('start_date'));
        $end_date = Carbon::createFromDate($request->get('end_date'));

        $posts = Post::orderByDesc('likes')
            ->with('category')
            ->get();

        return Response::json($posts)->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attribute = $request->validate([
            'title' => 'required|unique:posts|string|between:4,255',
            'description' => 'required|string|between:4, 155',
            'category_id' => 'required|int',
            'image_url' => 'required|string|between:4, 255',
            'published_at'=> 'nullable|sometimes|date',

        ]);

        $post = Auth::user()->posts()->create($attribute);

        return Response::json($post)->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {

        return Response::json($post->load('category'))->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $attribute = $request->validate([
            'title' => 'required|unique:posts|string|between:10,255',
            'description' => 'required|string|between:10, 155',
            'category_id' => 'required|int',
            'image_url' => 'required|string|between:10, 255',
            'published_at'=> 'nullable|sometimes|date'
        ]);

        return Response::json($post)->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
//        $posts = Category::find(1)->posts()->delete();
        $post->delete();

        return Response::json($post)->setStatusCode(204);
    }
}
