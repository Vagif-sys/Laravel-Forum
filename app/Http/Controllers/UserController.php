<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    
    public function update(Request $request,$id){
       
 
       $validateData = $request->validate([
           'username'=>'required|min:3|max:255',
           'email'=>'required',
           'phone' => 'required',
           'education' => 'required|string|max:255',
           'skills' =>'required',
           'profession' =>'required|string|max:255',
           'country' =>'required|string|max:255',
           'bio' =>'required|string|max:255',
       ]);

        
        $user = User::find($id);
     
        $user->name = $validateData['username'];
        $user->email = $validateData['email'];
        $user->phone = $validateData['phone'];
        $user->education = $validateData['education'];
        $user->skills = $validateData['skills'];
        $user->profession = $validateData['profession'];
        $user->country = $validateData['country'];
        $user->bio = $validateData['bio'];

        $user->save();
      
        toastr()->success('Your details was updated successfully');
        return back();
    }

}


