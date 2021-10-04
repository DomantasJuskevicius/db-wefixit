<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

class PostsApiController extends Controller
{
    public function index(){

        return Post::all();
    }

    public function getPost($postid){
        if(Post::where('id', $postid)->exists()){
            $post = Post::where('id', $postid)->get();
            return response($post, 200);
        } else {
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }
    }

    public function getPostComments($postid, Comment $comments){
        if(Post::where('id', $postid)->exists()){
            return response(array(
                $post = Post::where('id', $postid)->get(),
                $comments = Comment::where('post_id', $postid)->get()), 200);
        } else {
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }
    }

    public function store(){
        request()->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
        ]);

        return Post::create([
            'title' => request('title'),
            'content' => request('content'),
            'category_id' => request('category_id'),
        ]);
    }

    public function update(Request $request, $postid){
        if (Post::where('id', $postid)->exists()){
            $post = Post::find($postid);
            $post->title = is_null($request->title) ? $post->title : $request->title;
            $post->content = is_null($request->content) ? $post->content : $request->content;
            $post->category_id = is_null($request->category_id) ? $post->category_id : $request->category_id;
            $post->save();

            return response()->json([
                "message" => "Post update finished"
            ], 200);
        }
        else{
            return response()->json([
                "message" => "Post missing"
            ], 404);
    
        }
    }

    public function destroy($postid){
        if(Post::where('id', $postid)->exists()){
            $post = Post::find($postid);
            $post->delete();

            return response()->json([
                "message" => "Post removed"
            ], 200);
        } 
        else{
            return response()->json([
                "message" => "Post missing"
            ], 404);
        }
    }
}
