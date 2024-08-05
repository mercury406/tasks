@extends('tasks.tasks-layout')
@section('title', 'Tasks')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-3">Tasks</h1>
        @foreach($tasks as $task)
            @include('tasks.task-item', $task)
        @endforeach
        {{$tasks->links()}}
    </div>
@endsection
