<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;

class CountryController extends Controller
{
    public function index(){
        return response()->json(Country::get(), 200);//return all countries and a 200 for a success
    }

    public function show($id){
        //this will return the requested country by id. However, if the user asks for a nonexistent id, nothing will happen, and there will be no feedback. This is a problem. We want to solve this.
        $country = Country::find($id);
        if (is_null($country)) {
            return response()->json('Record not found', 404);
        }
        return response()->json($country, 200);
    }

    public function store(Request $request){//We use the request as argument
        $country = Country::create($request->all());//the model will create a country in the db. We save this country in the $country variable, because we want to return this
        return response()->json($country, 201);
    }

    public function update(Request $request, Country $country){
        $country->update($request->all());
        return response()->json($country, 200);
    }

    public function destroy(Request $request, Country $country){
        $country->delete();
        return response()->json(null, 204);
    }
}
