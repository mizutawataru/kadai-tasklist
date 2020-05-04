<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UsersController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->microposts()->orderBy("created_at", "desc")->paginate(10);
            
            $data = [
                "user" => $user,
                "microposts" => $microposts,
            ];
        }
        
        return view("welcome", $data);
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $microposts = $user->microposts()->orderBy("created_at", "desc")->paginate(10);
        
        $data = [
            "user" => $user,
            "microposts" => $microposts,
        ];
        
        $data += $this->counts($user);
        
        return view("users.show", $data);
    }
}