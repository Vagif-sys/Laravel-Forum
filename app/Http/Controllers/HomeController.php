<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
class HomeController extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index()
    {


        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to see your posts.');
        }


    
        // Fetch latest post for the logged-in user
        $latest_user_post = Discussion::where('user_id', auth()->id())->latest()->first();
        
        // Fetch the latest post overall
        $latest = Discussion::latest()->first();
        
        return view('home', compact('latest_user_post', 'latest'));
    }
    
}
