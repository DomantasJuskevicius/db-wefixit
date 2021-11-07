<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Quotation;
use Illuminate\Support\Facades\Auth;
use DB;

class CommentsApiController extends Controller
{
    public function index(){
        return Comment::all();
    }

    public function getComment($commentid){

        if (Comment::where('id', $commentid)->exists()) {
            $comment = Comment::where('id', $commentid)->get();
            return response($comment, 200);
        } 
        else {
            return response()->json([
            "message" => "Comment missing"
            ], 404);
        }
    }

    public function store(){

        $isGuest = auth()->guest();

        if(! $isGuest){
            $user_id = auth()->user()->id;

            return Comment::create([
                    'author'=> request('author'),
                    'comment_text' => request('comment_text'),
                    'post_id' => request('post_id'),
                    'user_id' => $user_id,
                ]);
        }
        else{
            return response()->json([
                "message" => "Unauthorized"
              ], 401);
        }
    }

    public function update(Request $request, $commentid){

        $isGuest = auth()->guest();

        if(! $isGuest){

            $user_id = auth()->user()->id;
            $user_role = auth()->user()->role;

            if(Comment::where('id', $commentid)->exists()){
                $comment = Comment::find($commentid);

                if($user_id == $comment->user_id || $user_role == 1){
                    $comment->author = is_null($request->author) ? $comment->author : $request->author;
                    $comment->comment_text = is_null($request->comment_text) ? $comment->comment_text : $request->comment_text;
                    $comment->post_id = is_null($request->post_id) ? $comment->post_id : $request->post_id;
                    $comment->user_id = $comment->user_id;
                    $comment->save();

                    return response()->json([
                        "message" => "comment updated"
                    ], 200);
                    } 
                    else {
                    return response()->json([
                        "message" => "Comment missing"
                    ], 404);

                }
            }
        }
        else{
            return response()->json([
                "message" => "Unauthorized"
            ], 401);
        }
    }

    public function destroy($commentid){

        $isGues = auth()->guest();

        if(! $isGuest){
            $user_id = auth()->user()->id;
            $user_role = auth()->user()->role;
            
            if(Comment::where('id', $commentid)->exists()) {
                $comment = Comment::find($commentid);
                $comment->delete();
    
                return response()->json([
                  "message" => "Comment removed"
                ], 202);
            } 
            else {
                return response()->json([
                    "message" => "Comment missing"
                ], 404);
            }  
        } 
    }
}
