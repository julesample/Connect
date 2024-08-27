<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'likes',
        'user_id'
        
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'note_id'); 
    }

    public function notes()
    {
        return $this->hasMany(Notes::class);
    }
}
