<?php

namespace App\Http\Controllers;

use App\TaskList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskListController extends Controller
{
    const DEFAULT_LIST_NAME = 'Default List Name';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('task_lists');
    }

    public function getLists()
    {
        $taskLists = TaskList::where('user_id', Auth::id())->get()->all();
        $sharedIds = DB::select('select task_list_id from shared_lists where shared_lists.user_to_id = ' . Auth::id());
        foreach ($sharedIds as $key => $value) {
            $sharedIds[$key] = $value->task_list_id;
        }
        $sharedLists = TaskList::whereIn('id', $sharedIds)->get()->all();
        $taskLists = array_merge($taskLists, $sharedLists);
        return response($taskLists, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskList = new TaskList();
        $taskList->name = self::DEFAULT_LIST_NAME;
        $taskList->user_id = Auth::id();
        $taskList->save();

        return response($taskList->jsonSerialize(), Response::HTTP_CREATED);
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
        $taskList = TaskList::findOrFail($id);
        $taskList->name = $request->name;
        $taskList->save();

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
        TaskList::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
