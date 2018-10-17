<?php

namespace App\Http\Controllers;

use App\SharedList;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShareController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function create(Request $request)
    {
        $sharedList = new SharedList();
        if($request->shareName && $request->listId) {
            if($request->shareName === Auth::user()->username) {
                return response(null, Response::HTTP_BAD_REQUEST);
            }
            $userToId = DB::table('users')->where('username', '=', $request->shareName)->get()->first();
            if(!$userToId) {
                return response(null, Response::HTTP_BAD_REQUEST);
            }
            $userToId = $userToId->id;
            $sharedList->task_list_id = $request->listId;
        } else {
            return response(null, Response::HTTP_BAD_REQUEST);
        }
        $sharedList->user_from_id = Auth::id();
        $sharedList->user_to_id = $userToId;
        $sharedList->save();

        return response($sharedList->jsonSerialize(), Response::HTTP_CREATED);
    }
}