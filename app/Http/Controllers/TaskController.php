<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks for a specific project.
     *
     * @param  int  $projectId
     * @return \Illuminate\Http\Response
     */
    public function index($projectId)
    {
        $project = Project::find($projectId);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        // Projeye ait tüm task'ları al
        $tasks = $project->tasks;
        return response()->json($tasks);
    }

    /**
     * Store a newly created task in a specific project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $projectId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $projectId)
    {
        $project = Project::with('users')->find($projectId);

        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'project_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // projedeki id'ler alınıyor
        // eğer projede değilse task'a eklenemez
        $projectUserIds = $project->users->pluck('id')->toArray();
        foreach ($request->input('user_ids') as $user_id) {
            if( !in_array($user_id, $projectUserIds) ) {
                return response()->json(
                    ['error' => 'These users cannot be added to this task because they are not in the project']
                );
            }
        }
        $task = new Task($request->all());
        $task->project_id = $projectId;
        $task->save();

        // Request'ten user_id alınıyor
        $userIds = $request->input('user_ids');
        $task->users()->attach($userIds);
        return response()->json($task, 201);
    }

    /**
     * Display the specified task.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function show($taskId)
    {
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    /**
     * Update the specified task in a specific project.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $taskId)
    {

        $task = Task::with('users')->find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'project_id' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $task->update($request->all());
        if (!empty($request->input('user_ids'))) {
            // projedeki idler alınıyor
            $projectUserIds = $task->project->users->pluck('id')->toArray();
            foreach ($request->input('user_ids') as $user_id) {
                if( !in_array($user_id, $projectUserIds) ) {
                    return response()->json(
                        ['error' => 'These users cannot be added to this task because they are not in the project']
                    );
                }
            }
            $userIds = $request->input('user_ids');
            $task->users()->sync($userIds);
        }
        // güncel kullanıcılar ile dönmesi için refresh yapıyoruz
        return response()->json($task->refresh());
    }

    /**
     * Remove the specified task from a specific project.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function destroy($taskId)
    {
        $task = Task::find($taskId);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
