@php
    //    $title = 'Update ' . $task?->title ?? 'Create task';
    //    $action = $task ?  : route('tasks.create');
    //    $method = $task ? 'put' : 'post';
@endphp

@extends('tasks.tasks-layout')

@section('title', 'Task')

@section('content')
    <div class="container">
        <h2>{{isset($task) ? 'Update ' . $task->title : 'Create task' }}</h2>
        <form action="{{isset($task) ? route('tasks.update', $task) : route('tasks.store')}}" method="POST">
            @method(isset($task) ? 'put' : 'post')
            @csrf
            <div class="mb-3">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="title"
                       value="@isset($task){{$task->title}}@endisset">
            </div>
            <div class="mb-3">
                <label for="description">Title</label>
                <textarea name="description" id="description" class="form-control" placeholder="description">@isset($task){{$task->description}}@endisset</textarea>
            </div>
            <div class="mb-3">
                <label for="status">Title</label>
                <select name="status" class="form-control" id="status">
                    <option value="0" {{isset($task) ? $task?->status->value == 0 ? 'selected' : '' : '' }}>Created</option>
                    <option value="1" {{isset($task) ? $task?->status->value == 1 ? 'selected' : '' : ''}}>Pending</option>
                    <option value="2" {{isset($task) ? $task?->status->value == 2 ? 'selected' : '' : ''}}>Finished</option>
                    <option value="100" {{isset($task) ? $task?->status->value == 100 ? 'selected' : '' : ''}}>Canceled</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="submit" value="Send" class="btn btn-success">
            </div>
        </form>
    </div>
@endsection
