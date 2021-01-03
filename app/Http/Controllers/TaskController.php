<?php

namespace App\Http\Controllers;

use App\Models\{Task, Category, Board};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Board $board
     * @return \Illuminate\Http\Response
     */
    public function index(Board $board)
    {
        //
        return view('boards.tasks.index', ['board' => $board]);

    }


    /**
     * Show the form for creating a new resource from a specific board.
     *
     * @param Board $board : le board pour lequel on crée une tâche
     * 
     * @return \Illuminate\Http\Response
     */
    public function create(Board $board)
    {
        //
        $user = Auth::user();
        $categories = Category::all();
        return view('boards.tasks.create', ["user" => $user, "categories" => $categories, 'board' => $board]); 
    }

    /**
     * Store a newly created resource in storage for a given board.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Board $board le board depuis/pour lequel on créé la tâche
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Board $board)
    {
        //
        $validatedData = $request->validate([
            'title' => 'required|string|max:255', 
            'description' => 'max:4096', 
            'due_date' => 'required|date|after:today',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);
        // TODO : il faut vérifier que le board appartient bien à l'utilisateur :(
        $validatedData['board_id'] = $board->id; 
        Task::create($validatedData); // Nouvelle méthode création, sans avoir à affecter propriété par propriété
        return redirect()->route('tasks.index', $board);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Board $board
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board, Task $task)
    {
        //
        return view('boards.tasks.show', ['board' => $board, 'task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Board $board
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board, Task $task)
    {
        $user = Auth::user();
        $categories = Category::all();
        return view('boards.tasks.edit', ['board' => $board, 'categories' => $categories, 'task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board $board
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255', 
            'description' => 'max:4096', 
            'due_date' => 'required|date|after:today',
            'state' => 'required|in:todo,ongoing,done',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);
        // TODO : il faut vérifier que le board appartient bien à l'utilisateur :(
        $validatedData['board_id'] = $board->id; 
        $task->update($validatedData); // Nouvelle méthode création, sans avoir à affecter propriété par propriété
        return redirect()->route('tasks.index', $board);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Board $board
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board, Task $task)
    {
        //
        $task->delete();
        return redirect()->route('tasks.index', $board);
    }
}
