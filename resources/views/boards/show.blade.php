@extends('layouts.main')

@section('title', "THE board")


@section('content')
    <h2>Bienvenu dans le board {{$board->title}}</h2>
    @foreach ($board->users as $user)
        <p>{{ $user->name }} : {{ $user->email }} 
            <form method="POST" action="{{route('boards.users.destroy', $user->pivot->id)}}">
                @csrf
                @method('DELETE')
                <button type="submit">Supprimer</button>
            </form>
        </p> 
    @endforeach
    <form method="POST" action="{{route('boards.users.store', $board)}}">
        @csrf
        <label for="user_id"></label>
        <select name="user_id" id="user_id">
            @foreach ($users as $user)
                <option value="{{$user->id}}">{{$user->name}}: {{$user->email}}</option>
            @endforeach
        </select>
        <button type="submit">Ajouter</button>
    </form>

    <br>
    <a href="{{route('tasks.create', $board)}}">Ajouter une tâche</a>
    
    <h3>On a la liste des tâches du board</h3>
    @foreach ($board->tasks as $task)
        <p>La task {{ $task->title }} :
            <a href="{{route('tasks.show', [$board,$task])}}">Voir</a>
            <a href="{{route('tasks.edit', [$board,$task])}}">Edit</a>
        <form method='POST' action="{{route('tasks.destroy', ["board" => $board, "task" => $task])}}">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
        </p>
    @endforeach
    
@endsection