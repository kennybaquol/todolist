<?php

namespace App\Http\Controllers;

use App\Models\ToDoList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ToDoListController extends Controller
{
    public function access(Request $request, $id)
    {
        $user = $request->user();
        $toDoList = $user->toDoLists()->findOrFail($id);

        return Inertia::render('Home', [
            'currentToDoList' => $toDoList,
            'toDoLists' => $user->toDoLists,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $user->toDoLists()->create();

        $toDoLists = $user->toDoLists()->orderBy('created_at', 'desc')->get();
        $currentToDoList = $toDoLists->first();
    
        return Inertia::render('Home', [
            'currentToDoList' => $currentToDoList,
            'toDoLists' => $toDoLists,
        ]);
    }

    public function update(Request $request, $id)
    {
        $toDoList = ToDoList::where('id', $id)
                            ->where('user_id', $request->user()->id)
                            ->firstOrFail(); // Ensures it exists and belongs to the user

        $toDoList->fill($request->all());
        $toDoList->save();
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();

        $toDoList = ToDoList::where('id', $id)
                            ->where('user_id', $user->id)
                            ->firstOrFail();

        $toDoList->delete();

        $toDoLists = $user->toDoLists()->orderBy('updated_at', 'desc')->get();
        $currentToDoList = $toDoLists->first();
    
        return Inertia::render('Home', [
            'currentToDoList' => $currentToDoList,
            'toDoLists' => $toDoLists,
        ]);    
    }
}
