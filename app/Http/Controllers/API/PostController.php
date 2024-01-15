<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'min:4'
        ]);
        $post = Post::create($validatedData);
        return response()->json($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'message' => 'There is no post'
            ]);
        }
        return response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->save();
        return response()->json(
            [
                "status" => 200,
                "message" => "Post updated"
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Post $post)
    {
        $post->delete($id);
        return response()->json([
            'status' => 200,
            'message' => 'Post deleted'
        ]);
    }
}
