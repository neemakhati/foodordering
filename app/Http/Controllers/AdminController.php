<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\food;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function chart()
    {
        return view('admin.order_chart');
    }
    public function getOrderDataByDayOfWeek()
    {
        $startOfWeek = now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = now()->endOfWeek()->format('Y-m-d');

        $ordersByDayOfWeek = Order::selectRaw('DAYNAME(created_at) as day_of_week, COUNT(*) as order_count')
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->groupBy('day_of_week')
            ->get();

        $orderCounts = [
            'Sunday' => 0,
            'Monday' => 0,
            'Tuesday' => 0,
            'Wednesday' => 0,
            'Thursday' => 0,
            'Friday' => 0,
            'Saturday' => 0,
        ];

        foreach ($ordersByDayOfWeek as $order) {
            $orderCounts[$order->day_of_week] = $order->order_count;
        }

        return response()->json([
            'orderCounts' => $orderCounts,
        ]);
    }
    public function getOrdersThisYear()
    {
        $orderCounts = Order::whereYear('created_at', now()->year)
            ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as order_count')
            ->groupBy('month')
            ->get()
            ->pluck('order_count', 'month')
            ->toArray();

        return response()->json(['orderCounts' => $orderCounts]);
    }

    public function analytics()
    {
        $topFoods = Food::select('food.id', 'food.title', DB::raw('count(*) as orders_count'))
            ->join('order_food_user', 'food.id', '=', 'order_food_user.food_id')
            ->groupBy('food.id', 'food.title')
            ->orderByDesc('orders_count')
            ->limit(10)
            ->get();

        return view('admin.top_foods', compact('topFoods'));
    }
    public function getTopFoods()
    {
        $topFoods = Food::select('food.id', 'food.title', DB::raw('count(order_food_user.food_id) as orders_count'))
            ->join('order_food_user', 'food.id', '=', 'order_food_user.food_id')
            ->groupBy('food.id', 'food.title')
            ->orderByDesc('orders_count')
            ->limit(10)
            ->get();

        return response()->json(['topFoods' => $topFoods]);
    }
    public function getTopUsers()
    {
        $topUsers = DB::table('order_food_user')
            ->join('users', 'order_food_user.user_id', '=', 'users.id')
            ->select('users.name', DB::raw('count(order_food_user.user_id) as order_count'))
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('order_count')
            ->take(10)
            ->get();

        return response()->json(['topUsers' => $topUsers]);
    }

    public function updateFood(Request $request, $id)
    {
        $food = Food::findOrFail($id);
        $food->title = $request->title;
        $food->price = $request->price;
        $food->description = $request->description;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('foodimage', $filename);
            $food->image = $filename;
        }

        $food->categories_id = $request->categories_id;
        $food->save();

        $food->load('cat');

        return response()->json(['status' => 'success', 'item' => $food]);
    }

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
    public function destroy($id)
    {
        try {
            $food = Food::findOrFail($id);
            $food->delete();

            return response()->json(['status' => 200, 'message' => 'Food item deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Error deleting food item.']);
        }
    }
    public function fetchFoodItem($id)
    {
        $food = Food::with('cat:id,name')->findOrFail($id);
        return response()->json(['food' => $food]);
    }



    public function fetchFoodItems(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);

        $foodItems = Food::with(['cat:id,name'])->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'food' => $foodItems->items(),
            'current_page' => $foodItems->currentPage(),
            'last_page' => $foodItems->lastPage(),
            'total' => $foodItems->total()
        ]);
    }


    public function uploadFoods(Request $request)
    {
        // Validate the request data for multiple food items
        $validatedData = $request->validate([
            'title.*' => 'required|string',
            'price.*' => 'required|numeric',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories_id.*' => 'required|exists:categories,id',
            'description.*' => 'required|string',
        ]);

        // Loop through the validated data and save each food item
        $titles = $validatedData['title'];
        $prices = $validatedData['price'];
        $images = $request->file('image');
        $categories_ids = $validatedData['categories_id'];
        $descriptions = $validatedData['description'];

        for ($i = 0; $i < count($titles); $i++) {
            $food = new Food();
            $food->title = $titles[$i];
            $food->price = $prices[$i];
            $food->description = $descriptions[$i];
            $food->categories_id = $categories_ids[$i];

            if (isset($images[$i])) {
                $image = $images[$i];
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('foodimage'), $imageName);
                $food->image = $imageName;
            }

            $food->save();
            $food->load('cat');
        }
        $food->load('cat');
        return response()->json(['status' => 'success', 'message' => 'Food items uploaded successfully']);
    }
    public function uploadFood(Request $request)
    {

        $validatedData = $request->validate([
            'title' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories_id' => 'required|exists:categories,id',
            'description' => 'required|string',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('foodimage'), $imageName);


        $food = new Food;
        $food->title = $validatedData['title'];
        $food->price = $validatedData['price'];
        $food->image = $imageName;
        $food->categories_id = $validatedData['categories_id'];
        $food->description = $validatedData['description'];
        $food->save();
        $food->load('cat');

        return response()->json(['status' => 'success', 'message' => 'Food item uploaded successfully', 'item' => $food]);
    }
    public function categoryMenu()
    {
        try{
            $food =food::all();
            $category = Category::orderBy('created_at', 'desc')->simplePaginate(4);

            return view('admin.categorymenu',compact('food', 'category'));
        }catch(Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }

//    public function deletefood($id)
//    {
//        try{
//            $data=food::find($id);
//            $data->delete();
//            return redirect()->back()->with('success','Item deleted successfully');
//        }catch(Exception $e){
//            return redirect()->back()->with('error','Something went wrong');
//        }
//    }
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
        $data = Order::orderBy('created_at', 'desc')->simplePaginate(7);

        return view('admin.order',compact('data'));
    }
    public function getOrderCount()
    {
        $count = Order::where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }


    public function getOrderDetails()
    {
        $orders = Order::where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get(['username', 'total_price', 'created_at']);

        // Mark fetched orders as read
        Order::where('is_read', false)->update(['is_read' => true]);

        return response()->json(['orders' => $orders]);
    }
    public function users()
    {
        $data =User::orderBy('created_at', 'desc')->simplePaginate(7);
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
