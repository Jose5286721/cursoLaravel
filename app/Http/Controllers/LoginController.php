<?php

namespace App\Http\Controllers;

use Hash;
use Validator;
use App\Models\User;
use App\Traits\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ResponseApi;

    public function login(Request $request){
        $this->validateLogin($request);
        $user = $this->checkUserValidate($request);
        return $this->success($user->createToken("cliente")->plainTextToken);
    }

    public function register(Request $request){
        $this->validateRegister($request);
        $user = User::create($request->only(["name","email","password"]));
        return $this->success($user->createtoken("client")->plainTextToken);
    }

    private function validateLogin($request){
        Validator::make($request->all(),array(
            "email" => ['required','email'],
            "password" => ['required']
        ))->validate();
    }

    private function checkUserValidate($request){
        $user = User::firstWhere('email',$request->email);
        if(!$user || !Hash::check($request->password,$user->password)){
            throw ValidationException::withMessages([
                'email' => ['Las credenciales son incorrectas'],
            ]);
        }
        return $user;
    }

    private function validateRegister($request){
        Validator::make($request->all(),array(
            "name" => array("required","string"),
            "email" => array("email","required","unique:users"),
            "password" => array("required","min:8","confirmed"),
        ))->validate();
    }
}
