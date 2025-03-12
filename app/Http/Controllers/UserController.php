<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = UserModel::where('username','manager9')->firstOrFail();
        return view('user',['data' => $user]);
        // $user = UserModel::findOrFail(1);
        // return view('user',['data' => $user]);
        // $user = UserModel::where('level_id','>',3)(function(){
        //     //...
        // });
        // $user = UserModel::FirstWhere('level_id',1);
        // return view('user', ['data' => $user]);
        // $user = UserModel::where('level_id',1)->first();
        // return view('user', ['data' => $user]);
        // $user = UserModel::find(1);
        // return view('user', ['data' => $user]);
    }
}
