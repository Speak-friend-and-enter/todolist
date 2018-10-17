<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    const LOGO_FOLDER = 'logos';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(Request $request)
    {
        if(Auth::User()->logo) {
            Storage::delete(self::LOGO_FOLDER . '/' . Auth::User()->logo);
        }

        $fileName = basename($request->logo->storePublicly(self::LOGO_FOLDER));
        Auth::User()->logo = $fileName;
        Auth::User()->save();

        return redirect(route('home'));
    }

    public function getLogo()
    {
        if (!auth()->check()) {
            return abort(404);
        }
        return response()->file(storage_path('app/public/logos/' . Auth::User()->logo));
    }
}