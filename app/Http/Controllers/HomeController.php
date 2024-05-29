<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;
class HomeController extends Controller
{
    public function myorderlist(Request $request)
    {

        $order = $request->all();
        dd($order);
        return view('myorderlist', compact('order'));
    }


    public function ordermail(Request $request)
    {
        $orderDetails = $request->all();
        $emailContent = [
            'address' => $orderDetails['address'],
            'phone' => $orderDetails['phone'],
            'cartItems' => []
        ];

        foreach ($orderDetails['name'] as $index => $name) {
            $emailContent['cartItems'][] = [
                'name' => $name,
                'price' => $orderDetails['price'][$index],
                'quantity' => $orderDetails['quantity'][$index]
            ];
        }
        Mail::send('emails.order', $emailContent, function ($message) {
            $message->to('neemakhati11@gmail.com')
                    ->subject('New Order Confirmation');
        });
        return redirect()->back()->with('success', 'Order placed successfully!');
    }


        public function sendEmail(Request $request)
    {
        Log::info('Form data received:', $request->all());

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        try {
            Mail::to('neemakhati11@gmail.com')->send(new ContactFormMail($request->all()));
        } catch (Exception $e) {
            Log::error('Error sending email:', ['exception' => $e]);
            return redirect()->back()->with('error', 'There was an error sending your message. Please try again later.');
        }
        return redirect()->back()->with('success', 'Sent!');
    }
        public function index(){
        $data = food::all();
        $categories = Category::all();
        return view('home',compact('data','categories'));

    }
    public function about(){
        $data = food::all();
        $categories = Category::all();
        return view('detail',compact('data','categories'));

    }
    public function reservation(){
        $data = food::all();
        $categories = Category::all();
        return view('reservation',compact('data','categories'));

    }
    public function addcart(Request $request,$id){
        try{
            if(Auth::id()){
                $user_id=Auth::id();

                $food_id=$id;
                $quantity=$request->quantity;
                $status="0";
                $cart = new Cart();
                $cart->user_id=$user_id;
                $cart->food_id=$food_id;
                $cart->quantity=$quantity;
                $cart->status=$status;
                $cart->save();

                return redirect()->back()->with('success','Item added to cart');

            }
            else{
                return redirect('/signin');

        }}
        catch(Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }
    public function showcart($id){
        try{
            $data = food::all();
            $categories = Category::all();
            $user = User::findOrFail($id);
            $cartItems = $user->carts()->with('food')->get();

            $count = $cartItems->count();

            return view('showcart', compact('count', 'cartItems','data','categories'));
        }catch(Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }
    public function deletecart($id){
        try{
            $data = Cart::findOrFail($id);
            $data->delete();
            return redirect()->back()->with('success','Deleted!!');
        }catch(Exception $e){
            return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function checkout(Request $request){
        try{
            $user = auth()->user();

            $cartItems = $user->carts;

            $order = new Order();
            $order->username = $user->name;
            $order->phone = $request->input('phone');
            $order->address = $request->input('address');
            $order->status = 'ordered';


            $totalPrice = 0;
            $foodDetails = [];
            foreach ($cartItems as $cartItem) {
                $totalPrice += $cartItem->food->price * $cartItem->quantity;
                $foodDetails[] = [
                    'name' => $cartItem->food->title,
                    'price' => $cartItem->food->price,
                    'quantity' => $cartItem->quantity
                ];
            }

            $order->total_price = $totalPrice;
            $order->food_details = json_encode($foodDetails);

            $order->save();
            $user->carts()->delete();
            return redirect()->back()->with('success','Order placed successfully');
    }catch(Exception $e){
        return redirect()->back()->with('error','Something went wrong');
    }
    }



    public function search(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            $foods = Food::where('title', 'like', '%' . $query . '%')->get();
            $html = '';
            foreach ($foods as $food) {
                $html .= '<div class="search-result" style="background-color: #dc3545; color: white; padding: 10px; margin: 10px; border-radius: 5px; display: flex; flex-direction: column; align-items: center;">';
                $html .= '<img src="/foodimage/' . $food->image . '" alt="' . $food->title . '" style="width: 100px; height: auto;">';
                $html .= '<p>' . $food->title . '</p>';
                $html .= '<p>' . $food->price . '</p>';
                $html .= '<p>' . $food->description . '</p>';
                $html .= '</div>';
            }
            return response()->json(['html' => $html]);
        } else {
            return response()->json(['html' => '']);
        }
    }
    public function showSignupForm()
    {
        return view('signup');
    }
    public function signup(Request $request){
        $incomingData = $request->validate([
            'name' => ['required','min:3','max:255',Rule::unique('users', 'name')],
            'email' => ['required','email',Rule::unique('users', 'name')],
            'password' => 'required|min:6|max:255'
        ]);

        $user = User::create($incomingData);

        auth()->login($user);

        return redirect('/redirectsuser');
    }
    public function showSigninForm()
    {
        return view('signin');
    }

    public function adminshowSigninForm()
    {
        return view('adminsignin');
    }
    public function adminlog(Request $request)
    {
        $incomingData = $request->validate([
            'adminemail' => 'required|email|max:255',
            'adminpassword' => 'required|min:6|max:255'
        ]);

        // Attempt to authenticate the user
        if (auth()->attempt(['email' => $incomingData['adminemail'], 'password' => $incomingData['adminpassword']])) {
            // Check if the authenticated user is an admin
            if (auth()->user()->usertype == "1") { // Assuming '1' is for admin
                // Regenerate session to prevent session fixation attacks
                $request->session()->regenerate();

                // Redirect to the admin home page
                return redirect('/redirects');
            }

            // If the user is not an admin, log them out
            auth()->logout();
            return redirect()->back()->with('error', 'Only admins can log in from this page.');
        }

        // Authentication failed, return the admin signin form with an error message
        return view('signin')->with('error', 'Invalid credentials');
    }
    public function signin(Request $request)
    {
        $incomingData = $request->validate([
            'loginemail' => 'required|email|max:255',
            'loginpassword' => 'required|min:6|max:255'
        ]);

        if (auth()->attempt(['email' => $incomingData['loginemail'], 'password' => $incomingData['loginpassword']])) {
            // Check if the authenticated user is an admin
            if (auth()->user()->usertype == "1") {
                auth()->logout();
                return redirect()->back()->with('error', 'Admins cannot log in from the user login page.');
            }
            $request->session()->regenerate();
            return redirect('/redirectsuser');
        }

        return view('signin')->with('error', 'Invalid credentials');
    }




    public function redirects(){
//        $usertype= Auth::user()->usertype;
            return view("admin.adminhome");

    }
    public function redirectsuser(){
        $data = food::all();

        $categories = Category::all();

        $user_id=Auth::id();
        $count = Cart::where('user_id',$user_id)->count();
        return view("home",compact('data','count','categories'));
    }

}
