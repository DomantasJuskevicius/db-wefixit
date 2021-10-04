<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index(){

        return Category::all();
    }

    public function store(){
        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        return Category::create([
            'title'=> request('title'),
            'description' => request('description')
        ]);
    }

    public function update(Category $category){
        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $success = $category->update([
            'title'=> request('title'),
            'description' => request('description')
        ]);
    
        return['success' => $success];
    }
    public function destroy(Category $category){
        $success = $category->delete();
        return['success' => $success];
    }
}
