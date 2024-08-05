@php
    $bg = match ($task->status) {
        \App\Enums\TaskStatus::Created => 'bg-secondary',
        \App\Enums\TaskStatus::Pending => 'bg-info',
        \App\Enums\TaskStatus::Completed => 'bg-success',
        \App\Enums\TaskStatus::Cancelled => 'bg-danger'
    };
    $status = match ($task->status) {
        \App\Enums\TaskStatus::Created => 'Created',
        \App\Enums\TaskStatus::Pending => 'Pending',
        \App\Enums\TaskStatus::Completed => 'Completed',
        \App\Enums\TaskStatus::Cancelled => 'Canceled'
    }
@endphp
<div class="card mb-3">
    <div class="card-header {{$bg}} text-light  ">
        {{$status}}
    </div>
    <div class="card-body">
        <h5 class="card-title">{{$task->title}}</h5>
        <p class="card-text">{{$task->description}}</p>
        <form action="{{route('tasks.destroy', $task)}}" method="POST">
            <a href="{{route('tasks.edit', $task)}}" class="btn btn-warning">Update</a>
            @csrf
            @method('delete')
            <input type="submit" class="btn btn-danger" value="Delete task">
        </form>
    </div>
</div>
