<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return OrderResource::collection(Order::all());
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
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'items.*.item_id' => 'required|exists:items,id|distinct',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer'
        ]);

        // Save the order
        $order = new Order;
        $order->customer_id = $request->input('customer_id');
        $order->date = $request->input('date');
        $order->save();

        // Add the items
        foreach ($request->input('items') as $item) {
            $order->items()->attach($item['item_id'], ['price' => $item['price'], 'quantity' => $item['quantity']]);
        }

        // Return a response with the new id
        return response(['id' => $order->id], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        // Validate the request
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'items.*.item_id' => 'required|exists:items,id|distinct',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer'
        ]);

        // Save the order
        $order->customer_id = $request->input('customer_id');
        $order->date = $request->input('date');
        $order->save();

        // Add the items
        $syncItems = [];
        foreach ($request->input('items') as $item) {
            $syncItems[$item['item_id']] = ['price' => $item['price'], 'quantity' => $item['quantity']];
        }
        $order->items()->sync($syncItems);

        // Return a 204 No Content response
        return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        // Delete the order's items
        $order->items()->sync([]);

        // Delete the order
        $order->delete();

        // Return a 204 No Content response
        return response(null, 204);
    }
}
