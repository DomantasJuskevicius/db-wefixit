<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Quotation;

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
        request()->validate([
            'author' => 'required',
            'comment_text'=> 'required',
            'post_id'=>'required',
        ]);

        $success = Comment::create([
            'author'=> request('author'),
            'comment_text' => request('comment_text'),
            'post_id' => request('post_id'),
        ]);

        return['success' => $success];
    }

    public function update(Request $request, $commentid){

        if (Comment::where('id', $commentid)->exists()) {
            $comment = Comment::find($commentid);
            $comment->author = is_null($request->author) ? $comment->author : $request->author;
            $comment->comment_text = is_null($request->comment_text) ? $comment->comment_text : $request->comment_text;
            $comment->post_id = is_null($request->post_id) ? $comment->post_id : $request->post_id;
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

    public function destroy($commentid){

        if(Comment::where('id', $commentid)->exists()) {
            $comment = Comment::find($commentid);
            $comment->delete();

            return response()->json([
              "message" => "Comment removed"
            ], 202);
          } else {
            return response()->json([
              "message" => "Comment missing"
            ], 404);
          }
    }
}
