<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Item::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'cost' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        // Save the item
        $item = new Item;
        $item->name = $request->input('name');
        $item->cost = $request->input('cost');
        $item->price = $request->input('price');
        $item->save();

        // Return a response with the new id
        return response(['id' => $item->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        // Validate the request
        $request->validate([
            'name' => 'required',
            'cost' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        // Save the item
        $item->name = $request->input('name');
        $item->cost = $request->input('cost');
        $item->price = $request->input('price');
        $item->save();

        // Return a 204 No Content response
        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        // Delete the item
        $item->delete();

        // Return a 204 No Content response
        return response(null, 204);
    }
}
