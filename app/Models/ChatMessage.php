<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sender_id',
        'message',
        'is_read',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}