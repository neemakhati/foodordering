<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Exception;
use Illuminate\Support\Str;
use App\Events\OrderPlaced;

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
    public function invalidhome(){
        $data = food::all();
        $categories = Category::all();
        return view('invalidhome',compact('data','categories'));

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

                return redirect()->back()->with('success','Added!');

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
    public function checkout(Request $request)
    {
        try {
            $user = auth()->user();
            $cartItems = $user->carts;

            $order = new Order();
            $order->username = $request->input('firstname');
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

            foreach ($cartItems as $cartItem) {
                $order->foods()->attach($cartItem->food->id, ['user_id' => $user->id]);

            }

            $user->carts()->delete();

            \Log::info('Order created', ['order' => $order]);
            event(new OrderPlaced($order));

            return redirect()->back()->with('success', 'Order placed successfully');
        } catch (\Exception $e) {
            \Log::error('Error placing order: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function testfunc(){
        $order= Order::where('username','Sita Shrestha')->first();
        event(new OrderPlaced($order));
        return view('testfunc');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        if ($query) {
            $foods = Food::where('title', 'like', '%' . $query . '%')->get();
            $html = '<div  style="display: flex; flex-wrap: nowrap; ">';
            foreach ($foods as $food) {
                $html .= '<div class="owl-item" style="flex: 0 0 auto; width: 200px; margin: 0 10px;">';
                $html .= '<div class="item">';
                $html .= '<div class="card card2" style="background-image: url(\'/foodimage/' . $food->image . '\'); width: 100%; height: 300px; position: relative; overflow: hidden;">';
                $html .= '<button class="price" style="position: absolute; top: 20px; left: 0px; background-color: #fb5849; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; height: auto;">' . $food->price . '</button>';
                $html .= '<div class="info" style="margin-top: 75px;">';
                $html .= '<h1 class="title">' . $food->title . '</h1>';
                $html .= '<p class="description">' . $food->description . '</p>';
                $html .= '</div></div></div></div>';
            }
            $html .= '</div>'; // End the div for the owl carousel

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
        $request->validate([
            'name' => ['required','min:3','max:255',Rule::unique('users', 'name')],
            'email' => ['required','email'],
            'password' => 'required|min:6|max:255'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);
        $user->verification_token = Str::random(60);
        $user->verification_token_expiry = Carbon::now()->addHours(4);
        $user->save();

        Mail::to($user->email)->send(new VerificationMail($user));
        return redirect('/')->with('message', 'Please check your email for verification link.');

    }
    public function verify($token)
    {
        $user = User::where('verification_token', $token)->first();

        if ($user) {
            if (Carbon::now()->gt($user->verification_token_expiry)) {
                return redirect('/signin')->with('error', 'This verification link has expired. Please request a new one.');
            }
            $user->isVerified = true;
            $user->verification_token = null;
            $user->save();

            auth()->login($user);

            return redirect('/redirectsuser')->with('message', 'Your email has been verified.');
        }

        return redirect('/signin')->with('error', 'Invalid verification link.');
    }
    public function showSigninForm()
    {
        return view('signin');
    }
    public function signin(Request $request)
    {
        $incomingData = $request->validate([
            'loginemail' => 'required|email|max:255',
            'loginpassword' => 'required|min:6|max:255'
        ]);

        if (auth()->attempt(['email' => $incomingData['loginemail'], 'password' => $incomingData['loginpassword']])) {
            $user = auth()->user();
            if ($user->usertype == "1") {
                auth()->logout();
                return redirect()->back()->with('error', 'Admins cannot log in from the user login page.');
            }
            if (!$user->isVerified) {
                return redirect('/homein');
            }
            $request->session()->regenerate();
            return redirect('/redirectsuser');
        }
        return redirect()->back()->with('error', 'Invalid credentials');
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
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
