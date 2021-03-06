<?php

namespace App\Http\Controllers;

use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request)
    {
    	//Validacion

    	$this->validate($request,[
    		'name' 		=>  'required|max:255',
    		'email'		=>	'required|email|max:255|unique:users',
    		'password'	=>	'required|min:6',
    	]);
    	//Guardar Usuario en la Base de Datos

    	$user = new User();
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = bcrypt($request->password);
    	$user->save();

    	//Response

    	return ["message" => "User Created", "user"=>$user];
    }

    public function login(Request $request)
    {
    	//Validacion

    	$this->validate($request,[
    		'email'		=>	'required|email',
    		'password'	=>	'required|min:6',
    	]);

    	$crediential=$request->only('email', 'password');

    	if(!$token=JWTAuth::attempt($crediential)){
    		return "Not Authenticated";
    	}

    	return ['token'=>$token];
    }
}
