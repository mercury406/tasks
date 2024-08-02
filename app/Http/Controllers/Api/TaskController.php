<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        /** @var Collection<Task> $tasks */
        $tasks = Task::forUser(auth()->id())
            ->orderByDesc('created_at')
            ->paginate(5);

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request): TaskResource
    {
        $data = array_merge($request->validated(), ['user_id' => auth()->id(), 'slug' => $request->title]);
        $task = Task::query()->create($data);

        return TaskResource::make($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): TaskResource
    {
        return TaskResource::make($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task): TaskResource
    {
        $task->update($request->validated());

        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): \Illuminate\Foundation\Application|\Illuminate\Http\Response|Application|ResponseFactory
    {
        $task->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }
}
