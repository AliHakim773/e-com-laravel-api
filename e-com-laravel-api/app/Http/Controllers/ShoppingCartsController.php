<?php

namespace App\Http\Controllers;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingCartsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // since a user can have only one open cart this will return his current open shopping cart
    public function view_cart()
    {
        $user_id = Auth::user()->id;

        $cart = ShoppingCart::where('user_id', $user_id)
            ->where('status', 'open')
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found',
            ], 404);
        }

        $cart_items = $cart->orders;

        return response()->json([
            'status' => 'success',
            'message' => 'current open cart',
            'cart' => $cart,
        ]);
    }

    // since all closed carts are carts that have been paid or made a transaction I just need to get all closed carts
    public function view_transaction_history()
    {
        $user_id = Auth::user()->id;

        $cart = ShoppingCart::where('user_id', $user_id)
            ->where('status', 'closed')
            ->get();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'History is empty',
            ], 404);
        }

        $cart_items = $cart->orders;

        return response()->json([
            'status' => 'success',
            'message' => 'current open cart',
            'cart' => $cart,
        ]);
    }

    // adding to cart is just adding an order 
    // if no cart is open it creats a cart with open status

    // to make a transaction you need to close the cart and pay
    public function make_transaction()
    {
        $user_id = Auth::user()->id;

        $cart = ShoppingCart::where('user_id', $user_id)
            ->where('status', 'open')
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'No Open Cart Found',
            ], 404);
        }

        $cart->status = 'closed';
        $cart->save();

        return response()->json([
            'status' => 'success',
            'message' => 'transaction complete',
            'cart' => $cart,
        ]);
    }
}
