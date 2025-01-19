<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   protected $guarded = [];

   public function article()
   {
      return $this->belongsTo(Article::class);
   }

   public function comments()
   {
      return $this->hasMany(Comment::class);
   }

   public function comment()
   {
      return $this->belongsTo(Comment::class);
   }

   public function user()
   {
      return $this->belongsTo(User::class);
   }
}