<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(){

    // $password = Hash::make('secret');
    // $bpassword = bcrypt('secret');
    // if (Hash::check('secret', $password))
    // {
    //     dump($password);
    //     dd($bpassword);
    // }

        $user = Auth::user();
        // dd($user->password);
        $pageTitle = 'Profile';
        return view('admin.profile.index', compact('pageTitle','user'));
    }

    public function update(Request $request){
        // dd($request);
        $user = Auth::user();
        $validators = $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$user->email.',email',
        ]);
            // dd($user->email);

        $user->name = $request->name;
        $user->email = $request->email;

        if($user->save()){
            return back()->with('message','Profile updated successfully!');
        }else{
            return back()->withErrors($validators);
        }
    }

    public function updatepassword(Request $request){
        $user = Auth::user();

        $validators = $request->validate([
            'old_password'=>'required',
            'new_password'=>'required',
        ]);
        // dump($user->password);
        if(Hash::check($request->old_password, $user->password)){
            $user->password = Hash::make($request->new_password);
        }else{
            return back()->withErrors('Old password incorrect, please enter correct password.');
        }

        if($user->save()){
            return back()->withMessage('Password updated successfully!, New Password is "'.$request->new_password.'"');
        }else{
            return back()->withErrors($validators);
        }
    }
}
