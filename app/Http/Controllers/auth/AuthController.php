<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use App\Models\HostelUser;

class AuthController extends Controller
{   
    // Login page view
    public function loginView(){
        return view('auth.login');
    }

    public function login(Request $request){
        // HostelUser::create([
        //     'username' => 'admin_user',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password123'),
        //     'user_type' => 1,  // 1 for admin
        //     'fname' => 'Admin',
        //     'lname' => 'User',
        //     'mobile_number' => '9876543210',
        // ]);
        // Define the validation rules
        $rules = [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ];

        // Define custom error messages
        $messages = [
            'username.required' => 'The username is required.',
            'username.string' => 'The username must be a valid string.',
            'username.max' => 'The username may not be greater than 255 characters.',
            'password.required' => 'The password is required.',
            'password.string' => 'The password must be a valid string.',
            'password.min' => 'The password must be at least 8 characters long.',
        ];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            // Redirect back to the form with the validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if the user exists by username
        $user = HostelUser::where('username', $request->username)->orWhere('email', $request->username)->first();

        // If user does not exist
        if (!$user) {
            return redirect()->back()->withErrors(['username' => 'Invalid username or email.'])->withInput();
        }

        // Check if the password matches
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Incorrect password.'])->withInput();
        }

        Session::put('logedin', true);
        Session::put('user_id', $user->id);
        Session::put('f_name', $user->fname);
        Session::put('l_name', $user->lname);
        Session::put('email', $user->email);
        Session::put('user_type', $user->user_type);
        
        return redirect()->route('adminDashboardView');
        
    }
}
