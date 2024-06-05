<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\food;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function foodMenu()
    {
        try{
            $food =food::all();
            $category = Category::all();

            return view('admin.foodmenu',compact('food', 'category'));
        }
        catch(Exception $e){
            return redirect()->back();
        }
    }

    public function categoryMenu()
    {
        try{
            $food =food::all();
            $category = Category::all();

            return view('admin.categorymenu',compact('food', 'category'));
    }catch(Exception $e){
        return redirect()->back()->with('error','Something went wrong');
    }
    }
    public function deletefood($id)
    {
        try{
            $data=food::find($id);
            $data->delete();
            return redirect()->back()->with('success','Item deleted successfully');
        }catch(Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }
    public function deletecategory($id)
    {
        try{
            $data=category::find($id);
            $data->delete();
            return redirect()->back()->with('success','Item deleted successfully');
        }catch(Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }
    public function updateview($id)
    {
        try{
            $data=food::find($id);
            $category = Category::all();
            return view('admin.updateview',compact('data', 'category'));
        }
        catch(Exception $e){
            return redirect()->back();
        }
    }
    public function updatecategory($id)
    {
        try{
            $data=category::find($id);
            $food = food::all();
            return view('admin.updatecategory',compact('data', 'food'));
        }
        catch(Exception $e){
            return redirect()->back();
        }
    }
    public function update(Request $request, $id)
    {
        try{
            $data=food::find($id);
            $image=$request->image;
            $imageName=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('foodimage',$imageName);

            $data->image=$imageName;
            $data->title=$request->title;
            $data->price=$request->price;
            $data->description=$request->description;

            $data->save();
            return redirect()->back()->with('success','Item updated successfully');
        }catch(Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }

    }
    public function updatecat(Request $request, $id)
    {
        try{
            $data=Category::find($id);

            $data->name=$request->name;
            $data->slug=$request->slug;
            $data->status=$request->status;

            $data->save();
            return redirect()->back()->with('success','Item updated successfully');
        }catch(Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }
    public function upload(Request $request)
    {
        try{
            $data= new food;

            $image=$request->image;
            $imageName=time().'.'.$image->getClientOriginalExtension();
            $request->image->move('foodimage',$imageName);
            $data->image=$imageName;
            $data->title=$request->title;
            $data->price=$request->price;
            $data->description=$request->description;

            $data->categories_id=$request->categories_id;

            $data->save();
            return redirect()->back()->with('success','Item uploaded successfully');
        }catch(Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }
    public function uploadcategory(Request $request)
    {
        try{
            $data= new category;
            $data->name=$request->name;
            $data->slug=Str::slug($request->name);
            $data->status=$request->status;

            $data->save();
            return redirect()->back()->with('success','Item uploaded successfully');
    }catch(Exception $e){
        return redirect()->back()->with('error','Something went wrong');
    }
    }
    public function orders()
    {
        $data = Order::orderBy('created_at', 'desc')->simplePaginate(10);

        return view('admin.order',compact('data'));
    }
    public function users()
    {
        $data =User::orderBy('created_at', 'desc')->get();
        return view('admin.user',compact('data'));
    }
    public function adminlogout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/adminlog');
    }
    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('users')->with('success', 'User deleted successfully.');
        } else {
            return redirect()->route('users')->with('error', 'User not found.');
        }
    }
    public function showAddFoodForm()
    {
        try{
            $food =food::all();
            $category = Category::all();

            return view('admin.addfood',compact('food', 'category'));
        }
        catch(Exception $e){
            return redirect()->back();
        }
    }
}
