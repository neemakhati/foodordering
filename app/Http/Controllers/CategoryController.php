<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\food;

class CategoryController extends Controller
{
    public function bakery($slug)
    {
        $cat = Category::where('slug', $slug)->first();
        $food = Food::where('categories_id', $cat->id)->get();
        $categories = Category::all();
        return view('bakery',compact('food', 'categories'));
    }
   
    public function appetizer()
    {
        $food =food::all();
        $category = Category::all();
        
        return view('appetizer',compact('food', 'category'));
    }
    public function dessert()
    {
        $food =food::all();
        $category = Category::all();
        
        return view('dessert',compact('food', 'category'));
    }
    
}
