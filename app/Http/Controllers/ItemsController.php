<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use Validator;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::all();
        return response()->json($items);//return a response (not a view!), formatted as JSON, with the $items in it. Obviously, this will give us all the items. For a single item we need the show().
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //even though we work with API now, we still need validation. So, here we go... We will use the Validator class for this. We use the validator, because this way if there is a validation issue, there will be an automatic feedback for the user. We will send this response with an if...validator... fails.
        $validator = Validator::make($request->all(), [
            'text' => 'required'
        ]);
        if ($validator->fails()) {
            $response = array('response' => $validator->messages(), 'success' => false);//here we create our response. It will be an array. The 'response' is the key. $validator->messages is the value. 'success' => false, because inf this IF case the $validator->fails(), so there was no succes.
            return $response;
        } else {//but, if the validation was successfull, then we want to continue, and write the data into the db.
            $item = new Item;//here we are creating a new item/db record. The item has a text and a body. So...
            $item->text = $request->input('text');
            $item->body = $request->input('body');
            $item->save();
            return response()->json($item);
        }

           
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::find($id);
        return response()->json($item);
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //even though we work with API now, we still need validation. So, here we go... We will use the Validator class for this. We use the validator, because this way if there is a validation issue, there will be an automatic feedback for the user. We will send this response with an if...validator... fails.
        $validator = Validator::make($request->all(), [
            'text' => 'required'
        ]);
        if ($validator->fails()) {
            $response = array('response' => $validator->messages(), 'success' => false);//here we create our response. It will be an array. The 'response' is the key. $validator->messages is the value. 'success' => false, because inf this IF case the $validator->fails(), so there was no succes.
            return $response;
        } else {//but, if the validation was successfull, then we want to continue, and write the data into the db.
            $item = Item::find($id);//here we will find the item/db record. The item has a text and a body. So... There is no form from where Laravel can read the $id from the uri. We set up the uri in the Postman. So, if we want to update item nr 2, than we type this as uri in the Postman: http://127.0.0.1:8000/api/items/2. Important: when updating from the Postman, you must type in _method (key) and PUT (value), while the main method is POST. 
            $item->text = $request->input('text');
            $item->body = $request->input('body');
            $item->save();
            return response()->json($item);//this response is actually being sent to the Postman. 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);//here we will find the item/db record. There is no form from where Laravel can read the $id from the uri. We set up the uri in the Postman. So, if we want to update item nr 2, than we type this as uri in the Postman: http://127.0.0.1:8000/api/items/2.
        $item->delete();
        $response = array('response' => 'Item deleted', 'success' => true);//here we create our response. It will be an array. 
        return $response;//this response is actually being sent to the Postman. Important: when deleting from the Postman, you must type in _method (key) and DELETE (value), while the main method is POST. We don't need text and the body here.
    }
}
