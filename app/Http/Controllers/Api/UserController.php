<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator, Input, Redirect;

class UserController extends Controller
{

    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */

    public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            return response()->json(['success' => $success], $this-> successStatus); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorized'], 401); 
        } 
    }

    public function logout(){   
    if (Auth::check()) {
        Auth::user()->token()->revoke();
        return response()->json(['success' =>'logout_success'],200); 
    }else{
        return response()->json(['error' =>'api.something_went_wrong'], 500);
    }
}

    /*public function login(Request $request) {
        try {
            $email       =   $request->input('email');
            $password    =   $request->input('password');

            $validator = Validator::make($request->all(), array(
                'email'      =>  'required',
                'password'   =>  'required'
            ));

            

            if ($validator->fails()) {
                //return $this->error('email_cannot_be_empty', 404);
                $error = $validator->errors();
                return response()->json($error, 404);
            } else {
                    
                $checker = User::where('email', $email)
                                //->where('password', $password)
                                ->first();
                if ($checker && Hash::check($password, $checker->password)) {
                    $user = User::where('email', $email)
                                ->first();
                    //return $this->success(['data' => $user, 'message' => 'success'], 200);
                    return response() -> json($user, 200);
                } else {
                    //return $this->error('account_does_not_exist', 404);
                    return response()->json('invalid', 404);
                }
            }

        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }*/

    public function getUser(Request $request){

        return response()->json($request->user());
    }
}
