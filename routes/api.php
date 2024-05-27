<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', function (Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if(!$user or !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $data = [
        'token' => $user->createToken($request->userAgent())->plainTextToken
    ];

    return Response::json($data)->setStatusCode(201);

});

Route::post('/register', function (Request $request) {

    $attribute = $request->validate([
        'email' => 'required|string|email',
        'name' => 'required|string',
        'password' => 'required|string'
    ]);

    $user = User::create($attribute);

    return response()->json($user)->setStatusCode(201);
});

Route::get('/posts',  [PostController::class, 'index']);

Route::post('/posts',  [PostController::class, 'store'])->middleware('auth:sanctum');

Route::get('/posts/{post}',  [PostController::class, 'show']);

Route::patch('/posts/{post}',  [PostController::class, 'update']);

Route::delete('/posts/{post}',  [PostController::class, 'destroy']);

Route::apiResource('/categories', CategoryController::class);
