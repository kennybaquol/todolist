<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{

    public function index(Request $request, $id)
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
}
