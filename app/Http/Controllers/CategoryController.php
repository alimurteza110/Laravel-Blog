<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories = Category::all();

        return Response::json($categories)->setStatusCode(200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attribute = $request->validate([
            'title' => 'required|unique:posts|string|between:4,255',
        ]);

        $category = Category::create($attribute);

        return Response::json($category)->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return Response::json($category->load('posts'))->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $attribute = $request->validate([
            'title' => 'required|unique:categories|string|between:10,255',
        ]);

        $category->update($attribute);

        return Response::json($category)->setStatusCode(201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
//        $posts = Category::find($category)->posts()->delete();
        $category->delete();

        return Response::json($category)->setStatusCode(204);
    }
}
