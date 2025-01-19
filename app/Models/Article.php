<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded=[];

    // Di dalam App\Models\Article.php
public function comments()
{
    return $this->hasMany(Comment::class);
}

}