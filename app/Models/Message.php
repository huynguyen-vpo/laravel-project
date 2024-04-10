<?php

namespace App\Models;

use GlobalScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'messages';
    protected $fillable = ['content'];
    
    // protected static function booted()
    // {
    //     static::addGlobalScope(new GlobalScope);
    // }

    public function scopeSoftDeletesIsNull($query){
        return $query->whereNull('deleted_at');
    }

    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
}
