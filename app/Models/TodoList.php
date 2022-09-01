<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id'];
    
    public static function boot() {
        parent::boot();
        self::deleting(function($todo_list) {
            $todo_list->tasks->each->delete();
        });
    }

    public function tasks() {
        return $this->hasMany(Task::class, 'todolist_id');
    }
}
