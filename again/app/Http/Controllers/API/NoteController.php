<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\note;

class NoteController extends Controller
{
    protected function store(Request $request){
        $validator = Validator::make($request->all(),[
            "element_module_id" => "required| max:191 ",
            "eleve_id" => "required| max:191",
            "note" => "required"
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => 400,
                "errors" => $validator->messages(),
            ]);
        }
        else{
        $note = new note; 
        $note->element_module_id = $request->input("element_module_id");
        $note->eleve_id = $request->input("eleve_id");
        $note->note = $request->input("note");

        $note->save();
        return response()->json([
            "status" => 200,
            "message" => "Note Added successfully"
        ]);
    }
    }
    protected function index(){
        $note = note::All();
        return response()->json([
            "status" => 200,
            "note" => $note
        ]);
    }
    protected function edit($id){
        $note = note::find($id);
        if($note){
            return response()->json([
                "status" => 200,
                "note" => $note
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Note Not found"
            ]);
        }
    }
    protected function update(Request $request , $id){
        $note = note::find($id);
        if($note){
            $validator = Validator::make($request->all(),[
                "element_module_id" => "required| max:191 ",
                "eleve_id" => "required| max:191",
                "note" => "required"
            ]);
            if($validator->fails()){
                return response()->json([
                    "status" => 400,
                    "errors" => $validator->messages(),
                ]);
            }
            else{
            $note->element_module_id = $request->input("element_module_id");
            $note->eleve_id = $request->input("eleve_id");
            $note->note = $request->input("note");
    
            $note->update();
            return response()->json([
                "status" => 200,
                "message" => "Note Updated successfully"
            ]);
        }
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "note Not found"
            ]);
        }
    }
    protected function destroy($id){
        $note = note::find($id);
        if($note){
            $note->delete();
            return response()->json([
                "message" => "note Deleted successfully",
                "status" => 200
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "note Not found"
            ]);
        }
    }
}
