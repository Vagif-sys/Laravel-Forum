<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewCategory extends Notification
{
    use Queueable;

    public $category;
    public function __construct($category)
    {
        $this->category = $category;
    }

  
    public function via($notifiable)
    {
        return ['database'];
    }

  
    public function toDatabase($notifiable)
    {
        $user = User::find($this->category->user_id);
   
        return [
            'name'=> $user->name,
            'email'=> $user->email,
            'message'=>$user->name." created".$this->category->title
        ];
    }
}
