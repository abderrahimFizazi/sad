<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Eleve;

class EleveController extends Controller
{
    protected function store(Request $request){
        $validator = Validator::make($request->all(),[
            "nom" => "required| max:191 ",
            "prenom" => "required| max:191",
            "filiere_id" => "required | max:191",
            "user_id" => "required ",
            "niveau"=> "required",
            'image' => 'required| image| mimes:jpeg,png,jpg',


        ]);
        if($validator->fails()){
            return response()->json([
                "status" => 400,
                "errors" => $validator->messages(),
            ]);
        }
        else{
        $eleve = new Eleve ; 
        $eleve->nom = $request->input("nom");
        $eleve->prenom = $request->input("prenom");
        $eleve->user_id = $request->input("user_id");
        $eleve->niveau = $request->input("niveau");
        $eleve->filiere_id = $request->input("filiere_id");

        if($request->hasFile("image")){
            $file = $request->file("image");
            $extention = $file->getClientOriginalExtension();
            $filename = time() .'.' . $extention;
            $file->move("uploads/eleve/" , $filename);
            $eleve->image = 'uploads/eleve/' . $filename;
        }
        $eleve->save();
        return response()->json([
            "status" => 200,
            "message" => "Eleve Added successfully"
        ]);
    }
    }
 
    protected function edit($id){
        $eleve = Eleve::find($id);
        if($eleve){
            return elevense()->Json([
                "status" => 200,
                "eleve" => $eleve,
            ]);
        }
            else{
                return response()->Json([
                    "status" => 422,
                    "message" => "Eleve not found"
                ]);
            }
    }
    protected function update(Request $request , $id){
        $eleve = Eleve::find($id);
        if($eleve){
            $validator = Validator::make($request->all(),[
                "nom" => "required| max:191 ",
                "prenom" => "required| max:191",
                "filiere_id" => "required | max:191",
                "user_id" => "required ",
                "niveau"=> "required",
            ]);
            if($validator->fails()){
                return response()->json([
                    "status" => 400,
                    "errors" => $validator->messages(),
                ]);
            }
            else{
            $eleve->nom = $request->input("nom");
            $eleve->prenom = $request->input("prenom");
            $eleve->user_id = $request->input("user_id");
            $eleve->niveau = $request->input("niveau");
            $eleve->filiere_id = $request->input("filiere_id");
            $eleve->update();
            return response()->json([
                "status" => 200,
                "message" => "Eleve Updated successfully"
            ]);
        }
        }
        else{
            return response()->Json([
                "status" => 422,
                "message" => "Eleve not found"
            ]);
        }
    }
    protected function destroy($id){
        $eleve = Eleve::find($id);
        if($eleve){
            $eleve->delete();
            return response()->json([
                "message" => "Eleve Deleted successfully",
                "status" => 200
            ]);
        }
        else{
           return response()->json([
               "message" => "Eleve Not found",
               "status" => 404
           ]);
        }
    }
    protected function index(){
        $eleve =  eleve::All();
        return response()->json([
            "status" => 200,
            "eleve" => $eleve
        ]);
    }
}