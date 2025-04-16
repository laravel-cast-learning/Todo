<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //
    use hasFactory;
    protected $fillable = ['title','description','completed'];
}
