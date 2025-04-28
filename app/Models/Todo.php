<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    //
    use hasFactory;
    protected $fillable = ['title','user_id','description'];

    protected $attributes = [
        'status_id' => 1 // Default to pending (assuming pending has ID 1)
    ];

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
