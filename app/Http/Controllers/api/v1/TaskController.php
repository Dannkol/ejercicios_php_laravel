<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\v1\TaskResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\TaskRequest;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $user = Auth::user();

        $tasks = $user->tasks()->orderByDesc('id')->paginate();

        return TaskResource::collection($tasks);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $task = new Task();
        $task->user_id = Auth::id();
        // Guarda la tarea en la base de datos
        $task->fill($request->validated())->save();

        // Devuelve la respuesta JSON con la tarea creada y el código de estado HTTP 201 (CREATED)
        return response()->json([
            'message' => 'Tarea creada exitosamente',
            'task' => new TaskResource($task)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskRequest $request, Task $task)
    {

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        // Guarda la tarea en la base de datos
        $task->fill($request->validated())->save();

        return response()->json([
            'message' => 'Tarea actualizada exitosamente',
            'task' => new TaskResource($task)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskRequest $request, Task $task)
    {
        $title = $task->title;
        $task->delete();
        return response()->json([
            'messenge' => "task eliminado",
            'task' => new TaskResource($task)
        ], Response::HTTP_ACCEPTED);
    }
}
