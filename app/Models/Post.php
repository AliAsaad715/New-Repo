<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'bio'];

    public function comment() {
        return $this->hasMany(Comment::class);
    }

    public function tags() {
        return $this->hasMany(Tag::class);
    }

}