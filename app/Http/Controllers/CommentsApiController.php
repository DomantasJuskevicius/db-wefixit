<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use DB;
use App\Quotation;

class CommentsApiController extends Controller
{
    public function index($postid){
        return $comments = DB::table('comments')->where('post_id', $postid)->get();
    }

    public function store($postid){
        request()->validate([
            'author' => 'required',
            'comment_text'=> 'required',
            'post_id'=>'required',
        ]);

        $success = Comment::create([
            'author'=> request('author'),
            'comment_text' => request('comment_text'),
            'post_id' => request($postid),
        ]);

        return['success' => $success];
    }

    public function update(Comment $comment, $postid){
        request()->validate([
            'author' => 'required',
            'comment_text'=> 'required',
            'post_id'=>'required',
        ]);

        $success = $comment->update([
            'author'=> request('title'),
            'comment_text' => request('content'),
            'post_id' => request($postid),
        ]);
    
        return['success' => $success];
    }
    public function destroy($comment){
        $success = $comment->delete();
        return['success' => $success];
    }
}
