<?php

namespace App\Models;

use Laravel\Prompts\Note;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    protected $fillable = ['content', 'user_id', 'note_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function note()
    {
        return $this->belongsTo(Note::class, 'note_id');
    }

    protected $rules=[
        'content' => ['required', 'string', 'min:5', 'max:150'],
    ];
    use HasFactory;
}
