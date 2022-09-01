<?php

namespace App\Http\Controllers;

use App\Models\TodoList;

class TodoListController extends Controller
{

    public function index() {
        $lists = auth()->user()->todolists;
        return [
            'lists' => $lists
        ];
    }

    public function show(TodoList $todolist) {
        return $todolist;
    }

    public function store() {
        $attr = request()->validate([
            'name' => ['required']
        ]);
        $todolist = auth()->user()->todolists()->create($attr);
        return $todolist;
    }

    public function destroy(TodoList $todolist) {
        return $todolist->delete();
    }

    public function update(TodoList $todolist) {
        $attr = request()->validate([
            'name' => ['required']
        ]);
        $todolist->update($attr);
        return $todolist;
    }
}
