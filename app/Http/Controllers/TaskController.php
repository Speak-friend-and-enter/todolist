<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    public function getTasks(Request $request)
    {
        $tasks = Task::where('task_list_id', $request->listId)->get();
        return response($tasks->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function create(Request $request)
    {
        $task = new Task();
        $task->name = 'Default Name';
        if($request->listId) {
            $task->task_list_id = $request->listId;
        } else {
            return response('', 500);
        }
        $task->save();

        return response($task->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        return response(null, Response::HTTP_BAD_GATEWAY);
        $task = Task::findOrFail($id);
        if($request->name) {
            $task->name = $request->name;
        }
        if($request->status) {
            $task->completed = $request->status;
        }
        $task->save();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Task::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
