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
}
