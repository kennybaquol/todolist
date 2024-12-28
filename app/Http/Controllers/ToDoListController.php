<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ToDoListController extends Controller
{
    public function access(Request $request, $id)
    {
        $user = $request->user();

        // Find the specific ToDoList for the user by its ID
        $toDoList = $user->toDoLists()->findOrFail($id);

        // Pass the selected ToDoList as 'currentToDoList' and all ToDoLists as 'toDoLists'
        return Inertia::render('Home', [
            'currentToDoList' => $toDoList,
            'toDoLists' => $user->toDoLists,  // All ToDoLists for navigation or other purposes
        ]);
    }

    public function store(Request $request)
    {
        $request->user()->toDoLists()->create();
    }

    public function update(Request $request, $id)
    {
        $toDoList = ToDoList::where('id', $id)
                            ->where('user_id', $request->user()->id)
                            ->firstOrFail(); // Ensures it exists and belongs to the user

        $toDoList->fill($request->all());

        $toDoList->save();
    }
}
