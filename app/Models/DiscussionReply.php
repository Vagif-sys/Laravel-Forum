<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Discussion;
use App\Models\User;

class DiscussionReply extends Model
{
    use HasFactory;

    protected $fillable = ['desc','user_id','discussion_id'];

    public function discussion(){

        return $this->belongsTo(Discussion::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
