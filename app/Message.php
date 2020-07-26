<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'is_read', 'text', 'from', 'to'
    ];

    public function fromUser()
    {
        return $this->hasOne(User::class, 'id', 'from');
    }
}
