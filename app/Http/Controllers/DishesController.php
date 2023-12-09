<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\DishRequest;

class DishesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishes = Dish::all();
        return view('kitchen.dish',compact('dishes'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('kitchen.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DishRequest $request)
    {
        $dish = new Dish();
        $dish->name = $request->name;
        $dish->category_id = $request->category;

        $imgName = date('YmdHis') .".". request()->dish_image->getClientOriginalExtension();
        request()->dish_image->move(public_path('images'),$imgName);
        $dish->image = $imgName;
        $dish->save();

        return redirect('dish')->with('message','Dish created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        $categories = Category::all();
        return view('kitchen.edit',compact('categories','dish'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dish $dish)
    {
        request()->validate([
            'name' =>'required',
            'category' => 'required'
        ]);

        $dish->name = $request->name;
        $dish->category_id = $request->category;

        if($request->dish_image){
            $imgName = date('YmdHis') . "." . request()->dish_image->getClientOriginalExtension();
            request()->dish_image->move(public_path('images'), $imgName);
            $dish->image = $imgName;
        }
        $dish->save();

        return redirect('dish')->with('message','Dish updated successfully.');



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return redirect('dish')->with('message','Dish removed successfully.');
    }

    public function order()
    {
        $orders = Order::whereIn('status',[1,2])->get();
        $rawStatus = config('res.order');
        $status = array_flip($rawStatus);
        return view('kitchen.order', compact('orders','status'));

    }

    public function approve(Order $order)
    {
        $order->status = config('res.order.processing');
        $order->save();
        return redirect('order')->with('message','Order approved');
    }

    public function cancel(Order $order)
    {
        $order->status = config('res.order.cancel');
        $order->save();
        return redirect('order')->with('message', 'Order rejected');
    }

    public function ready(Order $order)
    {
        $order->status = config('res.order.ready');
        $order->save();
        return redirect('order')->with('message', 'Order ready');
    }
}
