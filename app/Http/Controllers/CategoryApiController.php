<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryApiController extends Controller
{
    public function index(){

        $categories = Category::all();
        return response()->json([
            'status'=>200,
            'categories'=>$categories,
        ]);
    }

    public function getCategory($categoryid){
        if(Category::where('id', $categoryid)->exists()){
            $category = Category::where('id', $categoryid)->get();
            return response($category, 200);
        }
        else{
            return response()->json(["message" => "Category missing"], 404);
        }
    }

    public function getCategoryPosts($categoryid, Post $posts){
        if(Category::where('id', $categoryid)->exists()){
            return response(
                array(
                    $category = Category::where('id', $categoryid)->get(),
                    $posts = Post::where('category_id', $categoryid)->get()
                ), 200);
        }
        else{
            return response()->json([
                "message" => "Category missing"
            ], 404);
        }
    }

    public function store(){
        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $isGuest = auth()->guest();

        if(! $isGuest){
            $user_id = auth()->user()->id;

            return Category::create([
                'title'=> request('title'),
                'description' => request('description'),
                'user_id' => $user_id,
            ]);   
        }
        else{
            return response()->json(["message" => "Unauthorized"], 401);
        }
    }

    public function update(Request $request, $categoryid){
        $isGuest = auth()->guest();

        if(! $isGuest){
            $user_id = auth()->user()->id;
            $user_role = auth()->user()->role;

            if(Category::where('id', $categoryid)->exists()){

                $category = Category::find($categoryid);

                if($user_id == $category->user_id || $user_role == 1){
                    $category->title = is_null($request->title) ? $category->title : $request->title;
                    $category->description = is_null($request->description) ? $category->description : $request->description;
                    $category->save();

                    return response()->json(["message" => "category update finished"], 200);
                }else{
                    return response()->json([
                        "message" => "Unauthorized"
                    ], 401);
                }
            }else{
                return response()->json([
                    "message" => "Category not found"
                ], 404);
            }
        }
        else{
            return response()->json([
                "message" => "Unauthorized"
              ], 401);
        }
    }
    public function destroy($id)
    {

        $isGuest = auth()->guest();

        //Checks if user is logged in.
        if (!$isGuest)
        {

            $user_id = auth()->user()->id;
            $user_role = auth()->user()->role;

            //Checks if Category exists
            if (Category::where('id', $id)->exists())
            {

                $category = Category::find($id);

                if ($user_id == $category->user_id || $user_role == 1)
                {

                    $category->delete();

                    return response()
                        ->json(["message" => "Category deleted"], 202);
                }
                else
                {
                    return response()
                        ->json(["message" => "Unauthorized"], 401);
                }
            }
            else
            {
                return response()
                    ->json(["message" => "Category not found"], 404);
            }
        }
        else
        {
            return response()->json(["message" => "Unauthorized"], 401);
        }
    }
}
