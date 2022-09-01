<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TodoList;

class TaskController extends Controller
{
    public function index(TodoList $todolist) {
        return $todolist->tasks;
    }

    public function store(TodoList $todolist) {
        $attr = request()->validate([
            'title' => ['required']
        ]);

        $task = $todolist->tasks()->create($attr);
        return $task;
    }

    public function destroy(Task $task) {
        $task->delete();
    }

    public function update(Task $task) {
        $attr = request()->validate([
            'title' => ['sometimes', 'required'],
            'completed' => ['sometimes', 'required']
        ]);
        $task->update($attr);
        return $task;
    }
}
