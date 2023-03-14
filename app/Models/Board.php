<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $primaryKey = 'idx';

    protected $fillable = [
        'title',
        'content',
        'boardPw',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_idx');
    }

}
