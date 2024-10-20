<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Forum;

class Post extends Model
{
    use HasFactory;

    public function forum(){
        return $this->belongsTo(Forum::class);
    }
}
