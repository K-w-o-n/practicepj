<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tables = Table::all();
        $dishes = Dish::orderBy('id','desc')->get();
        $orders = Order::where('status', 4)->get();
        $rawStatus = config('res.order');
        $status = array_flip($rawStatus);
        return view('order_form', compact('dishes','tables','orders','status'));
    }

    public function submit(Request $request)
    {
        $data = array_filter($request->except('_token','table'));
        $orderId = rand();

        foreach ($data as $key => $value) {

            if($value > 1) {

                for ($i=0; $i < $value; $i++) {

                    $this->saveOrder($orderId,$key,$request);
                }

            }else{

                $this->saveOrder($orderId, $key, $request);
            }
        }

        return redirect('/order')->with('message', 'Ordered submitted');
    }

    public function saveOrder($orderId,$dish_id,$request)
    {
        $order = new Order();
        $order->order_id = $orderId;
        $order->dish_id = $dish_id;
        $order->table_id= $request->table;
        $order->status = config('res.order.new');

        $order->save();
    }

    public function serve(Order $order)
    {
        $order->status = config('res.order.done');
        $order->save();
        return redirect('/')->with('message', 'Order serve to customers');
    }
}
