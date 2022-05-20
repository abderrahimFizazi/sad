<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Filiere;
use \App\Models\Responsable_filiere;

class FiliereController extends Controller
{
    protected function store(Request $request){
        $validator = Validator::make($request->all(),[
            "code" => "required| max:191  | unique:filieres,code",
            "designation" => "required| max:191",
            "id_responsable" => "required",

        ]);
        if($validator->fails()){
            return response()->json([
                "status" => 400,
                "errors" => $validator->messages(),
            ]);
        }
        else{
        $filiere = new Filiere ; 
        $filiere->code = $request->input("code");
        $filiere->designation = $request->input("designation");
        $filiere->id_responsable = $request->input("id_responsable");
       
        $filiere->save();
        return response()->json([
            "status" => 200,
            "message" => "Filiere Added successfully"
        ]);
    }
    }
    protected function index(){
        $filiere = Filiere::All();
        return response()->json([
            "status" => 200,
            "filiere" => $filiere
        ]);
    }
    protected function edit($id){
        $filiere = Filiere::find($id);
        if($filiere){
            return response()->json([
                "status" => 200,
                "filiere" => $filiere
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Filiere Not found"
            ]);
        }
    }
    protected function update(Request $request , $id){
        $filiere = Filiere::find($id);
        if($filiere){
            $validator = Validator::make($request->all(),[
                "code" => "required| max:191  | unique:filieres,code",
                "designation" => "required| max:191",
                "id_responsable" => "required",
    
            ]);
            if($validator->fails()){
                return response()->json([
                    "status" => 400,
                    "errors" => $validator->messages(),
                ]);
            }
            else{
                $filiere->code = $request->input("code");
                $filiere->designation = $request->input("designation");
                $filiere->id_responsable = $request->input("id_responsable");
               
                $filiere->update();
                return response()->json([
                    "status" => 200,
                    "message" => "Filiere Updated successfully"
                ]);
            }
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Filiere Not found"
            ]);
        }
    }
    protected function destroy($id){
        $filiere = Filiere::find($id);
        if($filiere){
            $filiere->delete();
            return response()->json([
                "message" => "Filiere Deleted successfully",
                "status" => 200
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Filiere Not found"
            ]);
        }
    }
}
