<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\Forum;
use App\Models\User;
use App\Models\ReplyLike;
use App\Models\ReplyDislike;
use Illuminate\Support\Facades\URL;
use Telegram\Bot\Laravel\Facades\Telegram;
use Brian2694\Toastr\Facades\Toastr;
use App\Notifications\NewTopic;
use App\Notifications\NewReply;


class DiscussionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $forums = Forum::latest()->get();
        $forum  = Forum::findOrFail($id);
        return view('client.new-topic',compact('forums','forum'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $notify = 0;

       if($request->notify &&  $request->notify == 'on'){
          $notify = 1;
       }

       $topic = new Discussion;
       $topic->title = $request->title;
       $topic->desc = $request->desc;
       $topic->forum_id = $request->forum_id;
       $topic->user_id = auth()->id();
       $topic->notify =  $notify;

       $topic->save();

       $user = auth()->user();
       $user->increment('rank',10);

       $latestTopic = Discussion::latest()->first();
       $admins = User::where('is_admin',1)->get();
       foreach($admins as $admin){
          $admin->notify(new NewTopic($latestTopic));
       }


       $response = Http::withOptions([
        'verify' => 'C:\\laragon\\bin\\php\\php-8.2.23\\extras\\ssl\\cacert.pem', // Path to cacert.pem
        ])->post('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage', [
            'chat_id' => env('TELEGRAM_CHAT_ID', '1104146677'),
            'parse_mode' => 'HTML',
            'text' => auth()->user()->name.'started new discussion '. $request->title,
        ]);
        
       return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $topic = Discussion::find($id);
        if($topic){
            $topic->increment('view',1);
        }
        return view('client.topic',compact('topic'));
    }

    public function reply(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'desc' => 'required|string|max:500', // Adjust max length as needed
        ]);
    
        // Find the discussion
        $discussion = Discussion::find($id);
    
        // Check if the discussion exists
        if (!$discussion) {
            toastr()->error('Discussion not found.');
            return redirect()->back();
        }


    
        // Check if the user is authenticated
        if (!auth()->check()) {
            // Redirect or show an error if the user is not authenticated
            toastr()->error('You need to be logged in to reply.');
            return redirect()->back();
        }
    
        // Create the reply
        $reply = DiscussionReply::create([
            'desc' => $request->desc,
            'user_id' => auth()->id(),
            'discussion_id' => $id,
        ]);
    
        // Get the forum ID
        $forumId = $discussion->forum->id;
    
        // Generate the URL for the forum overview
        $url = URL::to("forum/overview/" . $forumId);
    
        // Prepare the message text for Telegram
        $messageText = sprintf(
            "<b>%s</b> replied to the topic <b>%s</b>\n%s\n<a href='%s'>Read it here</a>",
            auth()->check() ? auth()->user()->name : 'Guest',
            $discussion->title,
            $request->desc,
            $url
        );
    
        // Log the message text for debugging
        \Log::info('Message Text: ' . $messageText);
    
        // Send the message to Telegram with SSL verification
        try {
            $response = Http::withOptions([
                'verify' => 'C:\\laragon\\bin\\php\\php-8.2.23\\extras\\ssl\\cacert.pem', // Path to cacert.pem
            ])->post('https://api.telegram.org/bot' . env('TELEGRAM_BOT_TOKEN') . '/sendMessage', [
                'chat_id' => env('TELEGRAM_CHAT_ID', '1104146677'),
                'parse_mode' => 'HTML',
                'text' => 'New User'.auth()->user()->name.'has joined the forum'.auth()->user()->created_at,
            ]);
        
            if ($response->successful()) {
                \Log::info('Message sent to Telegram successfully');
            } else {
                \Log::error('Telegram API response: ' . $response->body());
                toastr()->error('Failed to send message to Telegram.');
            }
        } catch (\Exception $e) {
            \Log::error('Telegram Message Error: ' . $e->getMessage());
            toastr()->error('Failed to send message to Telegram.');
        }

        
       $latestReply = DiscussionReply::latest()->first();
       $admins = User::where('is_admin',1)->get();
       foreach($admins as $admin){
          $admin->notify(new NewReply($latestReply));
       }
        
        // Check if the reply was saved successfully
        if ($reply) {
            toastr()->success('You replied successfully.');
        } else {
            toastr()->error('Oops', 'Something went wrong.');
        }
    
        return redirect()->back();
    }
    
    


    
    public function edit($id)
    {
        //
    }

  
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        $reply = DiscussionReply::find($id);
        $reply->delete(); 
        toastr()->success('Reply is deleted successfully');
        return redirect()->back();
    }

    public function updates(){

        $updates = Telegram::getUpdates();

    }


    public function delete($id)
    {
        $discussion = DiscussionReply::find($id);
        $discussion->delete(); 
        toastr()->success('Reply is deleted successfully');
        return redirect()->back();
    }


    public function like($id)
    {
        if (!auth()->check()) {
            toastr()->error('You need to be logged in to like a reply.');
            return redirect()->route('login'); // Redirect to the login page if not authenticated
        }
    
        $reply = DiscussionReply::find($id);
      
        if (!$reply) {
            toastr()->error('Reply not found.');
            return back();
        }
    
        $user_id = $reply->user_id;
        $liked = ReplyLike::where('user_id', '=', auth()->id())->where('reply_id', '=', $id)->first();
    
        if ($liked) {
            toastr()->error('You already liked this reply.');
            return back();
        }
    
        $reply_like = new ReplyLike;
        $reply_like->user_id = auth()->id();
        $reply_like->reply_id = $id;
        $reply_like->save();
    
        $owner = User::find($user_id);
        $reply_like->increment('reply_like', 1);
        $owner->increment('rank', 10);
    
        toastr()->success('Like saved successfully.');
        return redirect()->back();
    }
    


    public function dislike($id)
    {
        $reply = DiscussionReply::find($id);
        $user_id = $reply->user_id;

        $liked = ReplyDislike::where('user_id','=',auth()->id())->where('reply_id'."=",$id)->first();

        if($liked){
            toastr()->error('You already liked reply');
            return back();
        }

        $reply_dislike = new ReplyDislike;
        $reply_dislike->user_id = auth()->id();
        $reply_dislike->reply_id = $id;
        $reply_dislike->save();
        $owner = User::find($user_id);
        $reply_dislike->increment('reply_dislike',1);
        $owner->increment('rank',10);
        toastr()->success('Like saved successfully');
        return redirect()->back();
    }

}
