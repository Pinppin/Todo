@extends('layouts.main')
@section('title', "Board's tasks")

@section('content')
    <p>Ici on va afficher les taches de la board {{$board->title}}.</p>
    <div>Les taches de la board</div>
    @foreach ($board->tasks as $task)
        <p>La task {{ $task->title }} :
            <a href="{{route('tasks.show', [$board,$task])}}">Voir</a>
            @can('update', $task)
            <a href="{{route('tasks.edit', [$board,$task])}}">Edit</a>
            @endcan
        <form method='POST' action="{{route('tasks.destroy', ["board" => $board, "task" => $task])}}">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
        </p>
    @endforeach
@endsection