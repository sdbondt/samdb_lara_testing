<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'todolist_id', 'completed'];

    public function todolist() {
        return $this->belongsTo(TodoList::class);
    }
}
