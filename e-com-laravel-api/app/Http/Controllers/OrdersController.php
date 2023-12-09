<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function add_order(Request $req)
    {
        $req->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'amount' => 'required',
        ]);

        $cart = ShoppingCart::where('user_id', $req->user_id)
            ->where('status', 'open')
            ->first();

        if (!$cart) {
            $cart = ShoppingCart::create([
                'user_id' => $req->user_id,
                'status' => 'open',
            ]);
        }

        $order = Order::create([
            'user_id' => $req->user_id,
            'product_id' =>  $req->product_id,
            'cart_id' => $cart->id,
            'amount' => $req->amount
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order added successfully',
            'order' => $order,
        ]);
    }

    public function edit_order(Request $req, $id)
    {
        if (!Order::find($id)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Order not found',
                'order_id' => $id,
            ]);
        }

        Order::where('id', $id)->update([
            'user_id' => $req->user_id,
            'product_id' =>  $req->product_id,
            'amount' => $req->amount
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order updated successfully',
        ]);
    }
}
