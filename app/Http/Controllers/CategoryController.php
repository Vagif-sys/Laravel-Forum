<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\notifications\NewCategory;
use App\Models\User;
use App\Models\Forum;
use App\Models\Discussion;
use Telegram;
class CategoryController extends Controller
{
  
    public function index()
    {
       $categories = Category::latest()->paginate(10);
       return view('admin.pages.categories',['categories'=>$categories]);
    }

 
    public function create()
    {
        return view('admin.pages.new_category');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $request->validate([
            'title'=>'required|min:3',
            'desc'=>'required|min:3',
            'image'=>'required|image|mimes:png,jpg'
        ]);

        $image = $request->image;
        $name = $image->getClientOriginalName();
        $new_name = time().$name;
        $dir = "storage/images/categories/";
        $image->move($dir,$new_name);

        $category->title = $request->title;
        $category->desc = $request->desc;
        $category->user_id = optional(auth()->user())->id;
        $category->image = $new_name;
        $category->save();

        $latestCategory = Category::latest()->first();
       $admins = User::where('is_admin',1)->get();
       foreach($admins as $admin){
          $admin->notify(new NewCategory($latestCategory));
       }

        try {
            $category->save();
            Session::flash('message', 'Category created successfully');
            $response = Http::withOptions([
                'verify' => 'C:\\laragon\\bin\\php\\php-8.2.23\\extras\\cacert.pem', // Path to cacert.pem
            ])->post('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage', [
                'chat_id' => env('TELEGRAM_CHAT_ID', '1104146677'),
                'parse_mode' => 'HTML',
                'text' => auth()->user()->name.' created ' . $request->title
            ]);
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle the exception gracefully
            Session::flash('error', 'Failed to create category: ' . $e->getMessage());
            return redirect()->back();
        }
    }

  
    public function show($id)
    {
        $category  = Category::findOrFail($id);
        
        return view('admin.pages.single_category',['category'=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.pages.edit_category',['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
         $request->validate([
             'title'=> 'required|min:3|max:255',
             'desc'=> 'required|max:10000',
             'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
         ]);

         $category->title = $request->title;
         $category->desc = $request->desc;


        if($request->hasFile('image')){

            if($category->image){
                Storage::delete($category->image);
            }

            
           
    

            $imagePath = $request->file('image')->store('images/categories','public');
            $category->image = $imagePath;

        
        }

        $category->save();

       return redirect()->back()->with('message','Category updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->with('message','Category deleted!');
    }


    public function search(Request $request)
    {
        
        $user = new User;
        $users_online = $user->allOnline();
        $forumCount = count(Forum::all());
        $discussCount = count(Discussion::all());
        $userCount = count(User::all());
        $newest = User::latest()->first();
        $totalCategories = count(Category::all());
        $categories = Category::query()->where('title','LIKE',"%($request->keyword)%")->get();
        $few_users = User::latest()->take(3)->get();
        return view('welcome',compact('categories','forumCount','discussCount','newest','userCount','users_online','few_users','totalCategories'));
        return back();
    }
}
