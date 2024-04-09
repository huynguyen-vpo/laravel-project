<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $fillable = ['content', 'post_id'];

    public function user() : BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function posts(): BelongsTo{
        return $this->belongsTo(Post::class);
    }
}
