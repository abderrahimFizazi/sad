<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Moyenne;

class MoyenneController extends Controller
{
    protected function store(Request $request){
        $validator = Validator::make($request->all(),[
            "filiere_id" => "required| max:191 ",
            "eleve_id" => "required| max:191",
            "moyenne" => "required",
            "niveau" => "required"
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => 400,
                "errors" => $validator->messages(),
            ]);
        }
        else{
        $moyenne = new Moyenne; 
        $moyenne->filiere_id = $request->input("filiere_id");
        $moyenne->eleve_id = $request->input("eleve_id");
        $moyenne->moyenne = $request->input("moyenne");
        $moyenne->niveau = $request->input("niveau");

        $moyenne->save();
        return response()->json([
            "status" => 200,
            "message" => "Moyenne Added successfully"
        ]);
    }
    }
    protected function index(){
        $moyenne = Moyenne::All();
        return response()->json([
            "status" => 200,
            "moyenne" => $moyenne
        ]);
    }
    protected function edit($id){
        $moyenne = Moyenne::find($id);
        if($moyenne){
            return response()->json([
                "status" => 200,
                "moyenne" => $moyenne
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Moyenne Not found"
            ]);
        }
    }
    protected function update(Request $request , $id){
        $moyenne = Moyenne::find($id);
        if($moyenne){
            $validator = Validator::make($request->all(),[
                "filiere_id" => "required| max:191 ",
                "eleve_id" => "required| max:191",
                "moyenne" => "required",
                "niveau" => "required"
            ]);
            if($validator->fails()){
                return response()->json([
                    "status" => 400,
                    "errors" => $validator->messages(),
                ]);
            }
            else{
            $moyenne->filiere_id = $request->input("filiere_id");
            $moyenne->eleve_id = $request->input("eleve_id");
            $moyenne->moyenne = $request->input("moyenne");
            $moyenne->niveau = $request->input("niveau");
    
            $moyenne->update();
            return response()->json([
                "status" => 200,
                "message" => "Moyenne updated successfully"
            ]);
        }
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Moyenne Not found"
            ]);
        }
    }
    protected function destroy($id){
        $moyenne = Moyenne::find($id);
        if($moyenne){
            $moyenne->delete();
            return response()->json([
                "message" => "Moyenne Deleted successfully",
                "status" => 200
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Moyenne Not found"
            ]);
        }
    }
}
