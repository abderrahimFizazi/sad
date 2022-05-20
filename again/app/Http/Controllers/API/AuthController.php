<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\User;

class AuthController extends Controller
{
    protected function Register(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required| max:191 | email |unique:users",
            "password" => "required| max:191|min:8",
            "login" => "required | max:191 | min:4 | unique:users"

        ]);
        if($validator->fails()){
            return response()->json([
                "status" => 400,
                "errors" => $validator->messages(),
            ]);
        }
        else{
        $user = new user ; 
        $user->login = $request->input("login");
        $user->email = $request->input("email");
        $user->password = $request->input("password");
        if( $request->input("role")){ $user->role = 1; }
        $user->save();
        return response()->json([
            "status" => 200,
            "message" => "user Added successfully",
            "user_id" => $user->id
        ]);
    }
    }
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'login' => 'required|max:191',
            'password' => 'required|min:8|max:191'
        ]);
        if($validator->fails()){
            return response()->json([
                "validation_errors" => $validator->messages(),
                "status" => 401
            ]);
        }
        else {
            $user = User::where('login', $request->login)->first();
         if (! $user || !($request->password=== $user->password)) {
             return response()->json([
                 "status" => 403,
                 "message" => "invalid Credenstials"
             ]);
        }
        else{
            if($user->role == 0){
            
               $token =  $user->createToken($user->login.'_EleveToken', [''])->plainTextToken;
               $role = 'eleve';

            }
            elseif($user->role == 1){
                $token =  $user->createToken($user->login.'Responsable_Token',['server:respo'])->plainTextToken;
                $role = 'Responsable';
            }
            elseif($user->role == 999){
                $token =  $user->createToken($user->login.'Responsable_Token',['server:admin'])->plainTextToken;
                $role = 'Admin';
            }
        }
             return response()->json([
                'status' => 200,
                'login' =>$user->login,
                'token'=>$token,
                'role'=>$role,
                'message' => 'Login successfully'
            ]);

        }
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            "status" => 200,
            "message" => "Logout Successfully"

        ]);
    }

    protected function destroy($id){
        $user = user::find($id);
        if($user){
            $user->delete();
            return response()->json([
                "message" => "user Deleted successfully",
                "status" => 200
            ]);
        }
        else{
           return response()->json([
               "message" => "user Not found",
               "status" => 404
           ]);
        }
    }
    protected function index(){
        $eleve =  User::has('eleve')->get();
        $respo =  User::has('responsable_filiere')->get();

        return response()->json([
            "status" => 200,
            "eleve" => $eleve,
            "responsable_filiere" => $respo
        ]);
    }
    protected function getLastId(){
        $last = User::latest('id')->select("id")->first();
        return response()->json([
            "status" => 200,
            "user_id" => $last
        ]);

    }
}