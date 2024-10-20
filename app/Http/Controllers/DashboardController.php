<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Forum;
use App\Models\Discussion;
use App\Models\Setting;

class DashboardController extends Controller
{
   public function home(){
      
      $categories = Category::latest()->paginate(15);
      $users = User::latest()->paginate(15);
      $discussions = User::latest()->paginate(15);
      $forums = Forum::latest()->paginate(15);
      return  view('admin.pages.home',compact('categories','users','discussions','forums'));
   }


   public function show($id){

      $latest_user_post = Discussion::where('user_id',$id)->latest()->first();
  
      $latest = Discussion::latest()->first();
       $user = User::find($id);
       return view('admin.pages.user',compact('user','latest_user_post','latest'));
   }


   public function users(){

       $users = User::latest()->paginate(15);
       return view('admin.pages.users',compact('users'));
   }

   public function destroy($id){

       $user = User::find($id);
       $user->delete();
       return redirect()->route('users')->with('success', 'User deleted successfully.');
   }


   public function  notifications(){

       $notifications = auth()->user()->notifications()->where('read_at',null)->get();

       return view('admin.pages.notifications',compact('notifications'));
   }

   public function markAsRead($id){

       $notifications = auth()->user()->notifications()->where('id',$id)->first();
       $notifications->markAsRead();
       return redirect()->route('notifications')->with('success', 'Notification marked as read successfully.');
   }


   public function notificationDestroy($id){

    $notifications = auth()->user()->notifications()->where('id',$id)->first();
    $notifications->delete();
    return redirect()->route('notifications')->with('success', 'Notification deleted successfully.');
}


    public function settingsForm(){

        return view('admin.pages.settings');
    }


    public function newSetting(Request $request){

        $settings = new Setting;
        $settings->forum_name = $request->forum_name;
        $settings->save();
        toastr()->success('Settings saved');
        return back();
    }
}
