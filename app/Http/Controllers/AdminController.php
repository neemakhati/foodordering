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
            $food =Food::orderBy('created_at', 'desc')->paginate(8);
            $category = Category::all();

            return view('admin.foodmenu',compact('food', 'category'));
        }
        catch(Exception $e){
            return redirect()->back();
        }
    }

    public function fetchFoodItems()
    {
        $food = Food::with(['cat:id,name'])->get();
        return response()->json(['food' => $food]);
    }

    // Method to upload food
    public function uploadFood(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories_id' => 'required|exists:categories,id',
            'description' => 'required|string',
        ]);

        // Handle file upload
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('foodimage'), $imageName);

        // Create a new food item
        $food = new Food;
        $food->title = $validatedData['title'];
        $food->price = $validatedData['price'];
        $food->image = $imageName;
        $food->categories_id = $validatedData['categories_id'];
        $food->description = $validatedData['description'];
        $food->save();

        // Return JSON response
        return response()->json(['status' => 'success', 'message' => 'Food item uploaded successfully', 'item' => $food]);
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
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'categories_id' => 'required|exists:categories,id',
                'description' => 'required|string',
            ]);

            $food = new Food();
            $food->title = $request->title;
            $food->price = $request->price;
            $food->description = $request->description;
            $food->categories_id = $request->categories_id;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time().'.'.$image->extension();
                $image->move(public_path('foodimage'), $imageName);
                $food->image = $imageName;
            }

            $food->save();

            $categoryName = $food->cat ? $food->cat->name : 'No Category';

            return response()->json([
                'item' => [
                    'id' => $food->id,
                    'title' => $food->title,
                    'price' => $food->price,
                    'description' => $food->description,
                    'category_name' => $categoryName,
                    'image' => $food->image,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error uploading food item: ' . $e->getMessage());

            return response()->json([
                'error' => 'There was an error uploading the food item. Please try again later.',
                'message' => $e->getMessage()
            ], 500);
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
        $data =User::orderBy('created_at', 'desc')->simplePaginate(10);
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
