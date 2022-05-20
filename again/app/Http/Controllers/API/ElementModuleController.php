<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \App\Models\Element_module;
use \App\Models\Module;

class ElementModuleController extends Controller
{
    protected function store(Request $request){
        $validator = Validator::make($request->all(),[
            "code" => "required| max:191",
            "designation" => "required| max:191",
            "vh" => "required| max:191",
            "poids" => "required| max:191",
            "id_module" => "required | max:191",
        ]);
        if($validator->fails()){
            return response()->json([
                "status" => 400,
                "errors" => $validator->messages(),
            ]);
        }
        else{
        $element = new Element_module ; 
        $element->code = $request->input("code");
        $element->designation = $request->input("designation");
        $element->id_module = $request->input("id_module");
        $element->vh = $request->input("vh");
        $element->poids = $request->input("poids");

        $element->save();
        return response()->json([
            "status" => 200,
            "message" => "Elemnt Added successfully"
        ]);
    }
    }
    protected function index(){
        $element = Element_module::All();
        return response()->json([
            "status" => 200,
            "module" => $element
        ]);
    }
    protected function edit($id){
        $element = Element_module::find($id);
        if($element){
            return response()->json([
                "status" => 200,
                "element" => $element
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Element module Not found"
            ]);
        }
    }
    protected function update(Request $request , $id){
        $element = Element_module::find($id);
        if($element){
            $validator = Validator::make($request->all(),[
                "code" => "required| max:191",
                "designation" => "required| max:191",
                "vh" => "required| max:191",
                "poids" => "required| max:191",
                "id_module" => "required | max:191",
            ]);
            if($validator->fails()){
                return response()->json([
                    "status" => 400,
                    "errors" => $validator->messages(),
                ]);
            }
            else{
            $element->code = $request->input("code");
            $element->designation = $request->input("designation");
            $element->id_module = $request->input("id_module");
            $element->vh = $request->input("vh");
            $element->poids = $request->input("poids");
    
            $element->update();
            return response()->json([
                "status" => 200,
                "message" => "Element Updated successfully"
            ]);
        }
    }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Elemnt Not found"
            ]);
        }
    }
    protected function destroy($id){
        $element = Element_module::find($id);
        if($element){
            $element->delete();
            return response()->json([
                "message" => "Elemnt Deleted successfully",
                "status" => 200
            ]);
        }
        else{
            return response()->json([
                "status" => 404,
                "message" => "Elemnt Not found"
            ]);
        }
    }
}
