<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    // ----------------------------- register api function ------------------------------//

    public function register(Request $request)
    {
        // Data validated
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ]);

        // Create user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Return a response as a json file
        return response([
            'status' => true,
            'massege' => 'User created successifully'
        ]);
    }

    // ----------------------------- Login api function ------------------------------//
        public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        /** @var User $user */
        if (!empty($user)) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('your Token')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'massege' => 'Login Successifully',
                    'Token' => $token
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'massege' => 'Password is incorrect'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'massege' => 'Email or Password is invalid'
            ]);
        }
    }

    // ----------------------------- Profile api function ------------------------------//    public function login(Request $request)
    public function profile(){
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'Your Profile',
            'user' => $user

            //Authorization -> Bearer token( in headers)
        ]);
        
    }

    // ----------------------------- Logout api function ------------------------------//    public function login(Request $request)
    public function logout(){
        /** @var User $user */
        Auth()->user()->tokens()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Logout successifully'
        ]);
    }

}
