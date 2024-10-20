<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Discussion;
use App\Models\Post;

class Forum extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function category(){
        return $this->belongsTo(Category::class);
    }


    public function discussions(){
        return $this->hasMany(Discussion::class);
    }


    public function posts(){

        return $this->hasMany(Post::class);
    }
}
