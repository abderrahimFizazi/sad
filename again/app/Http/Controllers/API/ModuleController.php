<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Filiere;
use \App\Models\Module;

class ModuleController extends Controller
{
    protected function store(Request $request){
        $validator = Validator::make($request->all(),[
            "code" => "required| max:191 | unique:modules,code",
            "designation" => "required| max:191",
            "semestre" => "required| max:191",
            "niveau" => "required| max:191",
            "id_filiere" => "required | max:191",
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => 400,
                "errors" => $validator->messages(),
            ]);
        }
        else{
        $module = new Module ; 
        $module->code = $request->input("code");
        $module->designation = $request->input("designation");
        $module->id_filiere = $request->input("id_filiere");
        $module->niveau = $request->input("niveau");
        $module->semestre = $request->input("semestre");

        $module->save();
        return response()->json([
            "status" => 200,
            "message" => "Module Added successfully"
        ]);
    }
    }
    protected function index(){
        $module = Module::All();
        return response()->json([
            "status" => 200,
            "module" => $module
        ]);
    }
    protected function edit($id){
        $module = Module::find($id);
        if($module){
            return response()->json([
                "status" => 200,
                "module" => $module
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "module Not found"
            ]);
        }
    }
    protected function update(Request $request , $id){
        $module = Module::find($id);
        if($module){
            $validator = Validator::make($request->all(),[
                "code" => "required| max:191  | unique:modules,code",
                "designation" => "required| max:191",
                "semestre" => "required| max:191",
                "niveau" => "required| max:191",
                "id_filiere" => "required | max:191",
            ]);
            if($validator->fails()){
                return response()->json([
                    "status" => 400,
                    "errors" => $validator->messages(),
                ]);
            }
            else{
                $module->code = $request->input("code");
                $module->designation = $request->input("designation");
                $module->id_filiere = $request->input("id_filiere");
                $module->niveau = $request->input("niveau");
                $module->semestre = $request->input("semestre");
               
                $module->update();
                return response()->json([
                    "status" => 200,
                    "message" => "Module Updated successfully"
                ]);
            }
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Module Not found"
            ]);
        }
    }
    protected function destroy($id){
        $module = Module::find($id);
        if($module){
            $module->delete();
            return response()->json([
                "message" => "Module Deleted successfully",
                "status" => 200
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Module Not found"
            ]);
        }
    }
}
