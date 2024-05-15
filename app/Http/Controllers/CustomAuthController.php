<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    public function login()
    {
        return view("auth.login");
    }

    public function registration()
    {
        return view("auth.registration");
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:12|min:5',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $request = $user->save();

        if ($request) {
            return redirect()->route('login')->with('success', 'You have registerd fully');
        } else {
            return back()->with('fail', 'Something wrong .......!!!!');
        }
    }
    public function loginUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|max:12|min:5',
        ]);

        $user = User::where('email', $request->email)->First();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->Session()->put('id', $user->id);
                return redirect()->route('products.index');
            } else {
                return back()->with('fail', 'Password not matches....');
            }
        } else {
            return back()->with('fail', 'This email is not regsiterd .......!!!!');
        }
    }

    public function dashboard()
    {
        // $data = array();
        // if(Session::has('loginId')){
        //     $data = User::where('id', Session::get('loginId'))->First();
        // }
        // return view('auth.dashboard',compact('data'));

        $data = User::get();
        return view('auth.dashboard', compact('data'));
    }
    public function logout(){
        // print_r(session()->all());exit;        
        Session::flush();
        // if(Session::has('loginId')){
        //     Session::pull('loginId');
        // Session::save();
        // print_r(session()->all());exit;        

            return redirect()->route('login');
        // }
    }
}



