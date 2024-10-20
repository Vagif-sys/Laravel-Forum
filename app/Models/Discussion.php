<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Forum;
use App\Models\DiscussionReply;

class Discussion extends Model
{
    use HasFactory;

    public function forum(){
        return $this->belongsTo(Forum::class);
    }

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function replies(){

        return $this->hasMany(DiscussionReply::class);
    }


  
}
