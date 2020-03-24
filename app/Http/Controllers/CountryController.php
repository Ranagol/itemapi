<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use Validator;

class CountryController extends Controller
{
    public function index(){
        return response()->json(Country::get(), 200);//return all countries and a 200 for a success
    }

    public function show($id){
        //this will return the requested country by id. However, if the user asks for a nonexistent id, nothing will happen, and there will be no feedback. This is a problem. We want to solve this.
        $country = Country::find($id);//find this country, and save it to the $country
        if (is_null($country)) {//If the $country is empty (there was no country under the requested id)
            return response()->json(["message" => 'Record not found'], 404);//return error message and 404
        }
        return response()->json($country, 200);
    }

    public function store(Request $request){//We use the request as argument
        $rules = [//these will be the validation rules
            'name' => 'required|min:3',
            'iso' => 'required|min:2|max:3',
        ];

        $validator = Validator::make($request->all(), $rules);//dear Validator, please make a validation on all request data with these $rules. Remeber, we must use Validator;
        if ($validator->fails()) {//if the validator fails
            return response()->json($validator->errors(), 400);
        }
        
        $country = Country::create($request->all());//the model will create a country in the db. We save this country in the $country variable, because we want to return this
        $country->save();
        return response()->json($country, 201);
    }

    public function update(Request $request, $id){
        $country = Country::find($id);
        if (is_null($country)) {
            return response()->json(["message" => 'Record not found'], 404);
        }
        $country->update($request->all());
        return response()->json($country, 200);
    }

    public function destroy(Request $request, $id){
        $country = Country::find($id);
        if (is_null($country)) {
            return response()->json(["message" => 'Record not found'], 404);
        }
        $country->delete();
        return response()->json(null, 204);
    }
}
