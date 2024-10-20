<?php

namespace App\Http\Controllers\frontend;



use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Forum;
use App\Models\Discussion;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(){

        $user = new User;
        $users_online = $user->allOnline();
        $forumCount = count(Forum::all());
        $discussCount = count(Discussion::all());
        $userCount = count(User::all());
        $newest = User::latest()->first();
        $categories = Category::latest()->get();
        $few_users = User::latest()->take(3)->get();
        return view('welcome',compact('categories','forumCount','discussCount','newest','userCount','users_online','few_users'));
    }


    public function categoryOverView($id){

        $user = new User;
        $users_online = $user->allOnline();
        dd($user->allOnline());
        $forumCount = count(Forum::all());
        $discussCount = count(Discussion::all());
        $userCount = count(User::all());
        $newest = User::latest()->first();
        $categories = Category::latest()->get();
        $category = Category::findOrFail($id);
       
        return view('welcome',compact('category','categories','forumCount','discussCount','newest','userCount','users_online'));

    }

    public function forumOverView($id){

       $forum = Forum::findOrFail($id);

       return view('client.forum-overview',compact('forum'));
    }


    public function profile($id){

        $latest_user_post = Discussion::where('user_id',$id)->latest()->first();
        $latest = Discussion::latest()->first();
        $user = User::find($id);
        return view('client.user_profile',compact('latest_user_post','latest','user'));
     }


     public function users(){

      
        $users = User::latest()->paginate(10);
        
        return view('client.users',compact('users'));
     }

     public function photoUpdate(Request $request,$id){

        if(!$request->profile_image){
            toastr()->error('Please select image');
            return back();
        }
        $image = $request->profile_image;
        $name = $image->getClientOriginalName();
        $new_image = time().$name;
        $dir = 'storage/profile';
        $image->move($dir,$new_image);
        $user = User::find($id);
        $user->image = $new_image;
        $user->save();
        toastr()->success('Image Updated!');
        return back();
        
     }
}
