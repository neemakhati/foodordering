<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{

//        return response()->json([
//            'access_token' => $user->api_token,
//            'token_type' => 'Bearer',
//        ]);


//        return response()->json([
//            'access_token' => $user->api_token,
//            'token_type' => 'Bearer',
//        ]);
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60),
        ]);
        auth()->login($user);

        return redirect('/redirectsuser');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }
        if ($user->usertype == "1") {
            return response()->json(['message' => 'Admins cannot log in from the user login page'], 403);
        }

        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        $user->api_token = Str::random(60);
        $user->save();

        return redirect('/redirectsuser');
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->api_token = null;
        $user->save();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
