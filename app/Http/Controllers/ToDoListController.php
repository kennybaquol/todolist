<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ToDoListController extends Controller
{
    public function update(Request $request, $id)
    {
        // Find the ToDoList by ID for the authenticated user
        $toDoList = ToDoList::where('id', $id)
                            ->where('user_id', $request->user()->id)
                            ->firstOrFail(); // Ensures it exists and belongs to the user

        $toDoList->fill($request->all());

        $toDoList->save();
    }
}
